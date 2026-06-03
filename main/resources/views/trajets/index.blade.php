@extends('layout')
@section('titre', 'Trajets disponibles')
@section('contenu')

<div class="hero-section text-white text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">
            <i class="bi bi-taxi-front text-brand-amber"></i> Trouvez votre taxi
        </h1>
        <p class="lead mb-0 text-light-emphasis">
            Réservez votre place pour les prochaines 24 heures
        </p>
    </div>
</div>

<div class="container">
    <div class="search-card mb-4">
        <form method="GET" action="{{ route('trajets.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold text-muted small">
                    <i class="bi bi-geo-alt"></i> Ville de départ
                </label>
                <select name="ville_depart" class="form-select form-select-lg">
                    <option value="">Toutes les villes</option>
                    @foreach($villes as $v)
                        <option value="{{ $v }}" {{ ($filters['ville_depart'] ?? '') === $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold text-muted small">
                    <i class="bi bi-geo-alt-fill"></i> Ville d'arrivée
                </label>
                <select name="ville_arrivee" class="form-select form-select-lg">
                    <option value="">Toutes les villes</option>
                    @foreach($villes as $v)
                        <option value="{{ $v }}" {{ ($filters['ville_arrivee'] ?? '') === $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-amber btn-lg w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0">
            @if(request()->hasAny(['ville_depart', 'ville_arrivee']))
                Résultats de recherche
            @else
                Trajets à venir
            @endif
            <span class="badge bg-brand-navy ms-2">{{ $trajets->count() }}</span>
        </h4>
        @if(request()->hasAny(['ville_depart', 'ville_arrivee']))
            <a href="{{ route('trajets.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Effacer filtres
            </a>
        @endif
    </div>

    @if($trajets->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-emoji-frown display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">Aucun trajet trouvé</h4>
            <p class="text-muted">Essayez de modifier vos critères de recherche.</p>
            <a href="{{ route('trajets.index') }}" class="btn btn-amber">
                <i class="bi bi-arrow-clockwise"></i> Voir tous les trajets
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($trajets as $trajet)
                <div class="col-lg-6">
                    <div class="card ride-card p-0">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-brand-navy">
                                            <i class="bi bi-clock"></i>
                                            {{ $trajet->heure_depart->format('H:i') }}
                                        </span>
                                        <span class="text-muted small">
                                            {{ $trajet->heure_depart->diffForHumans() }}
                                        </span>
                                    </div>
                                    <h5 class="mb-1">
                                        <i class="bi bi-geo-alt text-brand-amber"></i>
                                        {{ $trajet->ville_depart }}
                                        <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                        <i class="bi bi-geo-alt-fill text-brand-amber"></i>
                                        {{ $trajet->ville_arrivee }}
                                    </h5>
                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <span class="amount">{{ number_format($trajet->prix, 2) }} DH</span>
                                        <span class="text-muted small">
                                            <i class="bi bi-person"></i>
                                            {{ $trajet->places_disponibles }}/{{ $trajet->places_total }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="mb-2">
                                        @if($trajet->places_disponibles > 0)
                                            <span class="badge badge-green">
                                                <i class="bi bi-check-circle"></i>
                                                {{ $trajet->places_disponibles }} place(s)
                                            </span>
                                        @else
                                            <span class="badge badge-red">
                                                <i class="bi bi-x-circle"></i> Complet
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('trajets.show', $trajet) }}"
                                       class="btn btn-outline-dark btn-sm rounded-pill px-4 mt-2">
                                        Détails <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="progress seat-progress mx-4 mb-3" style="border-radius: 3px;">
                            @php $pct = (($trajet->places_total - $trajet->places_disponibles) / $trajet->places_total) * 100; @endphp
                            <div class="progress-bar bg-warning" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
