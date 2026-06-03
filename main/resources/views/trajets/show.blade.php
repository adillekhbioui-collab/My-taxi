@extends('layout')
@section('titre', 'Détail du trajet')
@section('contenu')

<div class="container py-4">
    <a href="{{ route('trajets.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour aux trajets
    </a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="bi bi-geo-alt text-brand-amber"></i>
                            {{ $trajet->ville_depart }}
                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                            <i class="bi bi-geo-alt-fill text-brand-amber"></i>
                            {{ $trajet->ville_arrivee }}
                        </h2>
                        <p class="text-muted mb-0">
                            <i class="bi bi-clock"></i>
                            {{ $trajet->heure_depart->format('l d F Y à H:i') }} —
                            <span class="fw-semibold">{{ $trajet->heure_depart->diffForHumans() }}</span>
                        </p>
                    </div>
                    <span class="badge fs-6 rounded-pill px-3 py-2 badge-{{ $trajet->couleur_statut }}">
                        {{ $trajet->label_statut }}
                    </span>
                </div>

                <hr>

                <div class="row g-4">
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small">Prix par place</p>
                        <p class="fw-bold fs-4 mb-0">{{ number_format($trajet->prix, 2) }} DH</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small">Places disponibles</p>
                        <p class="fw-bold fs-4 mb-0">
                            @if($trajet->places_disponibles > 0)
                                <span class="text-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $trajet->places_disponibles }} / {{ $trajet->places_total }}
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="bi bi-x-circle-fill"></i> Complet ({{ $trajet->places_total }} places)
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small">Chauffeur</p>
                        <p class="fw-bold mb-0">
                            <i class="bi bi-person-badge"></i> {{ $trajet->chauffeur_nom }}
                        </p>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-telephone"></i> {{ $trajet->chauffeur_tel }}
                        </p>
                    </div>
                </div>

                <hr>

                <div>
                    <p class="text-muted mb-1 small">Trajet créé par le courtier</p>
                    <p class="fw-semibold mb-0">{{ $trajet->courtier->name }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 text-center">
                @auth
                    @if(auth()->user()->isCourtier())
                        <div class="py-4">
                            <i class="bi bi-shield-lock display-4 text-muted"></i>
                            <h5 class="mt-2 text-muted">Espace courtier</h5>
                            <a href="{{ route('courtier.trajets.show', $trajet) }}" class="btn btn-amber mt-2">
                                Gérer ce trajet
                            </a>
                        </div>
                    @elseif($dejaReserve)
                        <div class="py-3">
                            <i class="bi bi-check-circle-fill display-4 text-success"></i>
                            <h5 class="mt-2 text-success">Vous avez déjà une réservation</h5>
                            <a href="{{ route('reservations.mes') }}" class="btn btn-outline-dark mt-2">
                                Voir mes réservations
                            </a>
                        </div>
                    @elseif($trajet->statut !== 'planifie' || !$trajet->estDansLes24h())
                        <div class="py-4">
                            <i class="bi bi-clock-history display-4 text-muted"></i>
                            <h5 class="mt-2 text-muted">Trajet non disponible</h5>
                        </div>
                    @else
                        <h5 class="mb-3">Réserver une place</h5>
                        <form action="{{ route('reservations.store', $trajet) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <span class="display-6 fw-bold">{{ number_format($trajet->prix, 2) }} DH</span>
                            </div>
                            <div class="form-check mb-3 text-start">
                                <input class="form-check-input" type="checkbox" name="payer" value="1" id="payerCheck">
                                <label class="form-check-label" for="payerCheck">
                                    Payer maintenant <span class="badge bg-info text-dark">Démo</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-amber btn-lg w-100">
                                <i class="bi bi-check2-circle"></i>
                                @if($trajet->places_disponibles > 0)
                                    Réserver ma place
                                @else
                                    Rejoindre la liste d'attente
                                @endif
                            </button>
                            @if($fileAttente > 0 && $trajet->places_disponibles <= 0)
                                <p class="text-muted small mt-2">
                                    <i class="bi bi-people"></i> {{ $fileAttente }} personne(s) déjà en attente
                                </p>
                            @endif
                        </form>
                    @endif
                @else
                    <div class="py-4">
                        <i class="bi bi-person-lock display-4 text-muted"></i>
                        <h5 class="mt-2">Connectez-vous pour réserver</h5>
                        <p class="text-muted small">Créez un compte ou connectez-vous pour réserver une place.</p>
                        <a href="{{ route('login') }}" class="btn btn-amber w-100 mb-2">
                            <i class="bi bi-box-arrow-in-right"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-dark w-100">
                            <i class="bi bi-person-plus"></i> S'inscrire
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

@endsection
