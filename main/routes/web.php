<?php

use App\Http\Controllers\Courtier\DashboardController as CourtierDashboardController;
use App\Http\Controllers\Courtier\ReservationController as CourtierReservationController;
use App\Http\Controllers\Courtier\TrajetController as CourtierTrajetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;

/* ─── Page d'accueil ─── */
Route::get('/', [TrajetController::class, 'index'])->name('home');

/* ─── Espace public : consultation des trajets ─── */
Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');
Route::get('/trajets/{trajet}', [TrajetController::class, 'show'])->name('trajets.show');

/* ─── Espace voyageur connecté ─── */
Route::middleware('auth')->group(function () {
    Route::get('/mes-reservations', [ReservationController::class, 'mesReservations'])->name('reservations.mes');
    Route::post('/trajets/{trajet}/reserver', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ─── Espace courtier (rôle requis) ─── */
Route::middleware(['auth', 'courtier'])->prefix('courtier')->name('courtier.')->group(function () {
    Route::get('/dashboard', [CourtierDashboardController::class, 'index'])->name('dashboard');

    Route::get('/trajets', [CourtierTrajetController::class, 'index'])->name('trajets.index');
    Route::get('/trajets/creer', [CourtierTrajetController::class, 'create'])->name('trajets.create');
    Route::post('/trajets', [CourtierTrajetController::class, 'store'])->name('trajets.store');
    Route::get('/trajets/{trajet}', [CourtierTrajetController::class, 'show'])->name('trajets.show');
    Route::get('/trajets/{trajet}/modifier', [CourtierTrajetController::class, 'edit'])->name('trajets.edit');
    Route::put('/trajets/{trajet}', [CourtierTrajetController::class, 'update'])->name('trajets.update');
    Route::delete('/trajets/{trajet}', [CourtierTrajetController::class, 'destroy'])->name('trajets.destroy');

    Route::get('/trajets/{trajet}/reservations', [CourtierReservationController::class, 'index'])->name('reservations.index');
});

require __DIR__.'/auth.php';
