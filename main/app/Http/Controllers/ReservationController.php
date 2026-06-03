<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Mes réservations (voyageur connecté).
     */
    public function mesReservations(): View
    {
        $reservations = Reservation::with('trajet')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('statut');

        return view('reservations.index', [
            'confirmees'  => $reservations->get(Reservation::STATUT_CONFIRMEE, collect()),
            'enAttente'   => $reservations->get(Reservation::STATUT_EN_ATTENTE, collect()),
            'annulees'    => $reservations->get(Reservation::STATUT_ANNULEE, collect()),
        ]);
    }

    /**
     * Réserver une place dans un trajet.
     * Si pleine → file d'attente (en_attente) avec position.
     * Sinon → confirmation immédiate.
     */
    public function store(Request $request, Trajet $trajet): RedirectResponse
    {
        abort_unless($trajet->estDansLes24h() && $trajet->statut === Trajet::STATUT_PLANIFIE, 404);

        $deja = $trajet->reservations()
            ->where('user_id', auth()->id())
            ->whereIn('statut', [Reservation::STATUT_EN_ATTENTE, Reservation::STATUT_CONFIRMEE])
            ->exists();

        if ($deja) {
            return back()->with('erreur', 'Vous avez déjà une réservation pour ce trajet.');
        }

        $data = $request->validate([
            'payer' => 'nullable|boolean',
        ]);

        $reservation = DB::transaction(function () use ($trajet, $data) {
            $trajetFrais = Trajet::lockForUpdate()->findOrFail($trajet->id);

            if ($trajetFrais->places_disponibles > 0) {
                return tap(Reservation::create([
                    'user_id'      => auth()->id(),
                    'trajet_id'    => $trajetFrais->id,
                    'statut'       => Reservation::STATUT_CONFIRMEE,
                    'position_file' => null,
                    'paye'         => (bool) ($data['payer'] ?? false),
                ]), function ($r) use ($trajetFrais) {
                    $trajetFrais->decrement('places_disponibles');
                });
            }

            $position = Reservation::where('trajet_id', $trajetFrais->id)
                ->where('statut', Reservation::STATUT_EN_ATTENTE)
                ->count() + 1;

            return Reservation::create([
                'user_id'      => auth()->id(),
                'trajet_id'    => $trajetFrais->id,
                'statut'       => Reservation::STATUT_EN_ATTENTE,
                'position_file' => $position,
                'paye'         => false,
            ]);
        });

        if ($reservation->estConfirmee()) {
            $msg = $reservation->paye
                ? '✅ Réservation confirmée et paiement enregistré (démo).'
                : '✅ Réservation confirmée ! Votre place est garantie.';
        } else {
            $msg = "⏳ Trajet complet. Vous êtes en liste d'attente à la position #{$reservation->position_file}.";
        }

        return redirect()->route('reservations.mes')->with('succes', $msg);
    }

    /**
     * Annuler une réservation.
     * Si elle était confirmée → libère la place + promeut le 1er en attente.
     * Si elle était en attente → recompacte les positions.
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        abort_unless($reservation->user_id === auth()->id(), 403);

        if ($reservation->estAnnulee()) {
            return back()->with('erreur', 'Cette réservation est déjà annulée.');
        }

        DB::transaction(function () use ($reservation) {
            $trajet = Trajet::lockForUpdate()->findOrFail($reservation->trajet_id);

            if ($reservation->estConfirmee()) {
                $trajet->increment('places_disponibles');
                $reservation->update(['statut' => Reservation::STATUT_ANNULEE]);

                $suivant = Reservation::where('trajet_id', $trajet->id)
                    ->where('statut', Reservation::STATUT_EN_ATTENTE)
                    ->orderBy('position_file')
                    ->lockForUpdate()
                    ->first();

                if ($suivant) {
                    $suivant->update([
                        'statut'        => Reservation::STATUT_CONFIRMEE,
                        'position_file' => null,
                    ]);
                    $trajet->decrement('places_disponibles');
                }
            } else {
                $position = $reservation->position_file;
                $reservation->update([
                    'statut'        => Reservation::STATUT_ANNULEE,
                    'position_file' => null,
                ]);

                Reservation::where('trajet_id', $trajet->id)
                    ->where('statut', Reservation::STATUT_EN_ATTENTE)
                    ->where('position_file', '>', $position)
                    ->decrement('position_file');
            }
        });

        return redirect()->route('reservations.mes')->with('succes', 'Réservation annulée.');
    }
}
