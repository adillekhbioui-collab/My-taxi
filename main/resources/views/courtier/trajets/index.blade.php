@extends('layout')
@section('titre', 'Gérer les trajets')
@section('contenu')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="section-title mb-0">
            <i class="bi bi-list-ul"></i> Mes trajets
        </h3>
        <a href="{{ route('courtier.trajets.create') }}" class="btn btn-amber">
            <i class="bi bi-plus-circle"></i> Nouveau trajet
        </a>
    </div>

    <div class="card p-4">
        <div class="mb-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-auto">
                    <select name="statut" class="form-select" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        @foreach(['planifie','en_cours','termine','annule'] as $s)
                            <option value="{{ $s }}" {{ $statut === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        @if($trajets->isEmpty())
            <p class="text-muted py-3 text-center">Aucun trajet trouvé.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Trajet</th>
                            <th>Départ</th>
                            <th>Chauffeur</th>
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
                            <td class="small">{{ $t->heure_depart->format('d/m/Y H:i') }}</td>
                            <td class="small">{{ $t->chauffeur_nom }}</td>
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
                                <a href="{{ route('courtier.trajets.show', $t) }}" class="btn btn-sm btn-outline-primary" title="Détails">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('courtier.trajets.edit', $t) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $trajets->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
