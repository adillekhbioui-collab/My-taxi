@extends('layout')
@section('titre', 'Tableau de bord courtier')
@section('contenu')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="section-title mb-0">
            <i class="bi bi-speedometer2"></i> Tableau de bord
            <span class="badge bg-brand-navy text-brand-amber ms-2">Courtier</span>
        </h3>
        <a href="{{ route('courtier.trajets.create') }}" class="btn btn-amber">
            <i class="bi bi-plus-circle"></i> Nouveau trajet
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-primary bg-opacity-10 text-center p-3">
                <h5 class="text-primary fw-bold">{{ $stats['trajets_24h'] }}</h5>
                <p class="mb-0 small text-muted">Trajets dans les 24h</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success bg-opacity-10 text-center p-3">
                <h5 class="text-success fw-bold">{{ $stats['reservations_total'] }}</h5>
                <p class="mb-0 small text-muted">Réservations actives</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-warning bg-opacity-10 text-center p-3">
                <h5 class="text-warning fw-bold">{{ $stats['reservations_attente'] }}</h5>
                <p class="mb-0 small text-muted">En liste d'attente</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-info bg-opacity-10 text-center p-3">
                <h5 class="text-info fw-bold">{{ $stats['places_restantes'] }}</h5>
                <p class="mb-0 small text-muted">Places disponibles</p>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i> Prochains trajets
            </h5>
            <a href="{{ route('courtier.trajets.index') }}" class="btn btn-sm btn-outline-dark">
                Voir tout <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($trajets->isEmpty())
            <p class="text-muted py-3 text-center">Aucun trajet à venir. <a href="{{ route('courtier.trajets.create') }}">Créer un trajet</a>.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Trajet</th>
                            <th>Départ</th>
                            <th>Prix</th>
                            <th>Places</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trajets as $t)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $t->ville_depart }}</span>
                                <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                <span class="fw-semibold">{{ $t->ville_arrivee }}</span>
                            </td>
                            <td>
                                <span class="small">{{ $t->heure_depart->format('d/m H:i') }}</span>
                                <br><span class="text-muted smaller">{{ $t->heure_depart->diffForHumans() }}</span>
                            </td>
                            <td>{{ number_format($t->prix, 2) }} DH</td>
                            <td>
                                <span class="badge {{ $t->places_disponibles > 0 ? 'badge-green' : 'badge-red' }}">
                                    {{ $t->places_disponibles }}/{{ $t->places_total }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $t->couleur_statut }}">{{ $t->label_statut }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('courtier.trajets.show', $t) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('courtier.trajets.edit', $t) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
