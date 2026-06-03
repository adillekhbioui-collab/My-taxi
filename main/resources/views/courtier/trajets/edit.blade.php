@extends('layout')
@section('titre', 'Modifier le trajet')
@section('contenu')

<div class="container py-4">
    <a href="{{ route('courtier.trajets.show', $trajet) }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="mb-4"><i class="bi bi-pencil-square text-warning"></i> Modifier le trajet</h3>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('courtier.trajets.update', $trajet) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ville de départ *</label>
                            <select name="ville_depart" class="form-select" required>
                                @foreach($villesDisponibles as $v)
                                    <option value="{{ $v }}" {{ old('ville_depart', $trajet->ville_depart) === $v ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ville d'arrivée *</label>
                            <select name="ville_arrivee" class="form-select" required>
                                @foreach($villesDisponibles as $v)
                                    <option value="{{ $v }}" {{ old('ville_arrivee', $trajet->ville_arrivee) === $v ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date et heure *</label>
                            <input type="datetime-local" name="heure_depart" class="form-control"
                                   value="{{ old('heure_depart', $trajet->heure_depart->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Prix (DH) *</label>
                            <input type="number" step="0.01" name="prix" class="form-control"
                                   value="{{ old('prix', $trajet->prix) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Places totales *</label>
                            <select name="places_total" class="form-select" required>
                                @for($i=3; $i<=8; $i++)
                                    <option value="{{ $i }}" {{ old('places_total', $trajet->places_total) == $i ? 'selected' : '' }}>{{ $i }} places</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom du chauffeur *</label>
                            <input type="text" name="chauffeur_nom" class="form-control"
                                   value="{{ old('chauffeur_nom', $trajet->chauffeur_nom) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone *</label>
                            <input type="text" name="chauffeur_tel" class="form-control"
                                   value="{{ old('chauffeur_tel', $trajet->chauffeur_tel) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Statut</label>
                            <select name="statut" class="form-select">
                                @foreach(['planifie','en_cours','termine','annule'] as $s)
                                    <option value="{{ $s }}" {{ old('statut', $trajet->statut) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-warning text-white btn-lg w-100">
                        <i class="bi bi-save"></i> Sauvegarder les modifications
                    </button>
                    <a href="{{ route('courtier.trajets.show', $trajet) }}" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
