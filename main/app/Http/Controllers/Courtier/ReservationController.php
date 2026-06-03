<?php

namespace App\Http\Controllers\Courtier;

use App\Http\Controllers\Controller;
use App\Models\Trajet;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Trajet $trajet): View
    {
        abort_unless($trajet->courtier_id === auth()->id(), 403);

        $trajet->load(['reservationsConfirmees.user', 'reservationsEnAttente.user']);

        return view('courtier.reservations.index', [
            'trajet'     => $trajet,
            'confirmees' => $trajet->reservationsConfirmees,
            'enAttente'  => $trajet->reservationsEnAttente,
        ]);
    }
}
