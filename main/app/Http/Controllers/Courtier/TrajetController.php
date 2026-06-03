<?php

namespace App\Http\Controllers\Courtier;

use App\Http\Controllers\Controller;
use App\Models\Trajet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TrajetController extends Controller
{
    public function index(Request $request): View
    {
        $query = Trajet::where('courtier_id', auth()->id())
            ->orderBy('heure_depart', 'desc');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $trajets = $query->paginate(10)->withQueryString();

        return view('courtier.trajets.index', [
            'trajets' => $trajets,
            'statut'  => $request->statut,
        ]);
    }

    public function create(): View
    {
        return view('courtier.trajets.create', [
            'villesDisponibles' => $this->villes(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ville_depart'       => 'required|string|max:80',
            'ville_arrivee'      => 'required|string|max:80|different:ville_depart',
            'heure_depart'       => 'required|date|after:now',
            'prix'               => 'required|numeric|min:0|max:9999.99',
            'places_total'       => 'required|integer|min:1|max:8',
            'chauffeur_nom'      => 'required|string|max:100',
            'chauffeur_tel'      => 'required|string|max:20',
        ], [
            'ville_arrivee.different' => 'La ville d\'arrivée doit être différente de la ville de départ.',
            'heure_depart.after'      => 'L\'heure de départ doit être dans le futur.',
        ]);

        $data['courtier_id']         = auth()->id();
        $data['places_disponibles']  = $data['places_total'];
        $data['statut']              = Trajet::STATUT_PLANIFIE;

        $trajet = Trajet::create($data);

        return redirect()
            ->route('courtier.trajets.show', $trajet)
            ->with('succes', 'Trajet créé avec succès.');
    }

    public function show(Trajet $trajet): View
    {
        abort_unless($trajet->courtier_id === auth()->id(), 403);

        $trajet->load(['reservationsConfirmees.user', 'reservationsEnAttente.user']);

        return view('courtier.trajets.show', [
            'trajet'        => $trajet,
            'confirmees'    => $trajet->reservationsConfirmees,
            'enAttente'     => $trajet->reservationsEnAttente,
        ]);
    }

    public function edit(Trajet $trajet): View
    {
        abort_unless($trajet->courtier_id === auth()->id(), 403);

        return view('courtier.trajets.edit', [
            'trajet'           => $trajet,
            'villesDisponibles' => $this->villes(),
        ]);
    }

    public function update(Request $request, Trajet $trajet): RedirectResponse
    {
        abort_unless($trajet->courtier_id === auth()->id(), 403);

        $data = $request->validate([
            'ville_depart'       => 'required|string|max:80',
            'ville_arrivee'      => 'required|string|max:80|different:ville_depart',
            'heure_depart'       => 'required|date',
            'prix'               => 'required|numeric|min:0|max:9999.99',
            'places_total'       => 'required|integer|min:1|max:8',
            'chauffeur_nom'      => 'required|string|max:100',
            'chauffeur_tel'      => 'required|string|max:20',
            'statut'             => ['required', Rule::in([
                Trajet::STATUT_PLANIFIE, Trajet::STATUT_EN_COURS,
                Trajet::STATUT_TERMINE, Trajet::STATUT_ANNULE,
            ])],
        ]);

        $data['places_disponibles'] = max(0, $data['places_total'] - ($trajet->places_total - $trajet->places_disponibles));

        $trajet->update($data);

        return redirect()
            ->route('courtier.trajets.show', $trajet)
            ->with('succes', 'Trajet mis à jour.');
    }

    public function destroy(Trajet $trajet): RedirectResponse
    {
        abort_unless($trajet->courtier_id === auth()->id(), 403);

        if ($trajet->reservations()->whereIn('statut', ['confirmee', 'en_attente'])->exists()) {
            return back()->with('erreur', 'Impossible de supprimer un trajet avec des réservations actives.');
        }

        $trajet->delete();

        return redirect()
            ->route('courtier.trajets.index')
            ->with('succes', 'Trajet supprimé.');
    }

    private function villes(): array
    {
        return [
            'Kénitra', 'Rabat', 'Salé', 'Casablanca', 'Bahraoui', 'Tiflet',
            'Khemisset', 'Meknès', 'Fès', 'Tanger', 'Tétouan', 'Marrakech',
            'Oujda', 'Nador', 'El Jadida', 'Safi', 'Béni Mellal',
        ];
    }
}
