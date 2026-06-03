@extends('layout')
@section('titre', $trajet->ville_depart . ' → ' . $trajet->ville_arrivee)
@section('contenu')

<div class="container py-4">
    <a href="{{ route('courtier.trajets.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Mes trajets
    </a>
    <a href="{{ route('courtier.trajets.edit', $trajet) }}" class="btn btn-sm btn-outline-warning mb-3 ms-2">
        <i class="bi bi-pencil"></i> Modifier
    </a>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="mb-1">
                            <i class="bi bi-geo-alt text-brand-amber"></i>
                            {{ $trajet->ville_depart }}
                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                            <i class="bi bi-geo-alt-fill text-brand-amber"></i>
                            {{ $trajet->ville_arrivee }}
                        </h2>
                        <p class="text-muted mb-0">
                            {{ $trajet->heure_depart->format('l d F Y à H:i') }}
                        </p>
                    </div>
                    <span class="badge badge-{{ $trajet->couleur_statut }} fs-6 px-3 py-2">{{ $trajet->label_statut }}</span>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-md-4">
                        <p class="text-muted mb-0 small">Prix</p>
                        <p class="fw-bold fs-5 mb-0">{{ number_format($trajet->prix, 2) }} DH</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-0 small">Places</p>
                        <p class="fw-bold mb-0">
                            <span class="badge {{ $trajet->places_disponibles > 0 ? 'badge-green' : 'badge-red' }} fs-6">
                                {{ $trajet->places_disponibles }}/{{ $trajet->places_total }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-0 small">Chauffeur</p>
                        <p class="fw-bold mb-0">{{ $trajet->chauffeur_nom }}</p>
                        <p class="small text-muted">{{ $trajet->chauffeur_tel }}</p>
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    Réservations confirmées ({{ $confirmees->count() }})
                </h5>
                @if($confirmees->isEmpty())
                    <p class="text-muted small">Aucune réservation confirmée.</p>
                @else
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($confirmees as $r)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <span class="fw-semibold">{{ $r->user->name }}</span>
                                    <span class="small text-muted ms-2">{{ $r->user->telephone ?? '—' }}</span>
                                </div>
                                <span class="badge badge-green">Confirmée</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h5 class="mb-3">
                    <i class="bi bi-hourglass-split text-warning"></i>
                    Liste d'attente ({{ $enAttente->count() }})
                </h5>
                @if($enAttente->isEmpty())
                    <p class="text-muted small">Aucune personne en attente.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($enAttente as $r)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <span class="fw-semibold">{{ $r->user->name }}</span>
                                    <span class="small text-muted ms-2">{{ $r->user->telephone ?? '—' }}</span>
                                </div>
                                <span class="badge bg-dark">Position #{{ $r->position_file }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4">
                <h5 class="mb-3"><i class="bi bi-link-45deg"></i> Liens rapides</h5>
                <a href="{{ route('courtier.trajets.edit', $trajet) }}" class="btn btn-warning text-white w-100 mb-2">
                    <i class="bi bi-pencil"></i> Modifier ce trajet
                </a>
                <a href="{{ route('courtier.trajets.create') }}" class="btn btn-amber w-100 mb-2">
                    <i class="bi bi-plus-circle"></i> Nouveau trajet
                </a>
                <a href="{{ route('courtier.reservations.index', $trajet) }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-people"></i> Gérer les réservations
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
