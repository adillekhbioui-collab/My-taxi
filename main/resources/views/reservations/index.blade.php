@extends('layout')
@section('titre', 'Mes réservations')
@section('contenu')

<div class="container py-4">
    <h3 class="section-title mb-4">
        <i class="bi bi-ticket-perforated"></i> Mes réservations
    </h3>

    @if($confirmees->isEmpty() && $enAttente->isEmpty() && $annulees->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-ticket display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">Aucune réservation</h4>
            <p class="text-muted">Vous n'avez pas encore réservé de place.</p>
            <a href="{{ route('trajets.index') }}" class="btn btn-amber">
                <i class="bi bi-search"></i> Voir les trajets disponibles
            </a>
        </div>
    @else
        @if($confirmees->isNotEmpty())
            <h5 class="mb-3">
                <i class="bi bi-check-circle-fill text-success"></i> Réservations confirmées
            </h5>
            <div class="row g-3 mb-4">
                @foreach($confirmees as $res)
                    <div class="col-lg-6">
                        <div class="card p-3 border-start border-success border-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        {{ $res->trajet->ville_depart }} →
                                        {{ $res->trajet->ville_arrivee }}
                                    </h6>
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-clock"></i>
                                        {{ $res->trajet->heure_depart->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="mb-0">
                                        <span class="badge badge-green">{{ $res->label_statut }}</span>
                                        @if($res->paye)
                                            <span class="badge bg-info text-dark"><i class="bi bi-credit-card"></i> Payé</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold">{{ number_format($res->trajet->prix, 2) }} DH</span>
                                    <form action="{{ route('reservations.destroy', $res) }}" method="POST"
                                          onsubmit="return confirm('Annuler cette réservation ?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger mt-2">
                                            <i class="bi bi-x-circle"></i> Annuler
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($enAttente->isNotEmpty())
            <h5 class="mb-3">
                <i class="bi bi-hourglass-split text-warning"></i> En liste d'attente
            </h5>
            <div class="row g-3 mb-4">
                @foreach($enAttente as $res)
                    <div class="col-lg-6">
                        <div class="card p-3 border-start border-warning border-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        {{ $res->trajet->ville_depart }} →
                                        {{ $res->trajet->ville_arrivee }}
                                    </h6>
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-clock"></i>
                                        {{ $res->trajet->heure_depart->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="mb-0">
                                        <span class="badge badge-amber">{{ $res->label_statut }}</span>
                                        <span class="badge bg-dark">
                                            Position #{{ $res->position_file }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold">{{ number_format($res->trajet->prix, 2) }} DH</span>
                                    <form action="{{ route('reservations.destroy', $res) }}" method="POST"
                                          onsubmit="return confirm('Annuler votre place en attente ?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger mt-2">
                                            <i class="bi bi-x-circle"></i> Quitter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($annulees->isNotEmpty())
            <details class="mb-4">
                <summary class="text-muted small fw-semibold" style="cursor: pointer;">
                    <i class="bi bi-archive"></i> Réservations annulées ({{ $annulees->count() }})
                </summary>
                <div class="mt-2">
                    @foreach($annulees as $res)
                        <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                            <div>
                                <span class="small">{{ $res->trajet->ville_depart }} → {{ $res->trajet->ville_arrivee }}</span>
                                <span class="badge badge-red ms-2">{{ $res->label_statut }}</span>
                            </div>
                            <span class="small text-muted">{{ $res->created_at->format('d/m/Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </details>
        @endif
    @endif
</div>

@endsection
