<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrajetController extends Controller
{
    /**
     * Liste publique des trajets dans les 24 prochaines heures.
     * Voyageurs connectés ou non peuvent consulter.
     */
    public function index(Request $request): View
    {
        $query = Trajet::query()
            ->planifie()
            ->dansLes24h()
            ->orderBy('heure_depart');

        if ($request->filled('ville_depart')) {
            $query->where('ville_depart', 'like', '%' . $request->ville_depart . '%');
        }

        if ($request->filled('ville_arrivee')) {
            $query->where('ville_arrivee', 'like', '%' . $request->ville_arrivee . '%');
        }

        $trajets = $query->get();

        $villes = Trajet::planifie()
            ->dansLes24h()
            ->select('ville_depart')
            ->distinct()
            ->orderBy('ville_depart')
            ->pluck('ville_depart');

        return view('trajets.index', [
            'trajets'  => $trajets,
            'villes'   => $villes,
            'filters'  => $request->only(['ville_depart', 'ville_arrivee']),
        ]);
    }

    /**
     * Détail d'un trajet + bouton de réservation (si voyageur connecté).
     */
    public function show(Trajet $trajet): View
    {
        abort_unless($trajet->estDansLes24h() && $trajet->statut === Trajet::STATUT_PLANIFIE, 404);

        $dejaReserve = false;
        if (auth()->check()) {
            $dejaReserve = $trajet->reservations()
                ->where('user_id', auth()->id())
                ->whereIn('statut', ['en_attente', 'confirmee'])
                ->exists();
        }

        return view('trajets.show', [
            'trajet'       => $trajet,
            'dejaReserve'  => $dejaReserve,
            'fileAttente'  => $trajet->reservationsEnAttente()->count(),
        ]);
    }
}
