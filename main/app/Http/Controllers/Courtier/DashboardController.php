<?php

namespace App\Http\Controllers\Courtier;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Trajet;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $courtier = auth()->user();

        $trajetsAvenir = Trajet::where('courtier_id', $courtier->id)
            ->where('heure_depart', '>=', Carbon::now())
            ->orderBy('heure_depart')
            ->get();

        $stats = [
            'trajets_total'        => Trajet::where('courtier_id', $courtier->id)->count(),
            'trajets_24h'          => $trajetsAvenir->where('heure_depart', '<=', Carbon::now()->addDay())->count(),
            'reservations_total'   => Reservation::whereIn('trajet_id', $trajetsAvenir->pluck('id'))->whereIn('statut', ['confirmee', 'en_attente'])->count(),
            'reservations_attente' => Reservation::whereIn('trajet_id', $trajetsAvenir->pluck('id'))->where('statut', 'en_attente')->count(),
            'places_restantes'     => $trajetsAvenir->sum('places_disponibles'),
        ];

        return view('courtier.dashboard', [
            'trajets' => $trajetsAvenir->take(5),
            'stats'   => $stats,
        ]);
    }
}
