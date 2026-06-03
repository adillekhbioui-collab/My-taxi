@extends('layout')
@section('titre', 'Nouveau trajet')
@section('contenu')

<div class="container py-4">
    <a href="{{ route('courtier.trajets.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="mb-4"><i class="bi bi-plus-circle text-brand-amber"></i> Nouveau trajet</h3>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('courtier.trajets.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ville de départ *</label>
                            <select name="ville_depart" class="form-select @error('ville_depart') is-invalid @enderror" required>
                                <option value="">-- Choisir --</option>
                                @foreach($villesDisponibles as $v)
                                    <option value="{{ $v }}" {{ old('ville_depart') === $v ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ville d'arrivée *</label>
                            <select name="ville_arrivee" class="form-select @error('ville_arrivee') is-invalid @enderror" required>
                                <option value="">-- Choisir --</option>
                                @foreach($villesDisponibles as $v)
                                    <option value="{{ $v }}" {{ old('ville_arrivee') === $v ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date et heure *</label>
                            <input type="datetime-local" name="heure_depart" class="form-control @error('heure_depart') is-invalid @enderror"
                                   value="{{ old('heure_depart') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Prix (DH) *</label>
                            <input type="number" step="0.01" min="0" name="prix" class="form-control @error('prix') is-invalid @enderror"
                                   value="{{ old('prix') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Places totales *</label>
                            <select name="places_total" class="form-select" required>
                                @for($i=3; $i<=8; $i++)
                                    <option value="{{ $i }}" {{ old('places_total') == $i ? 'selected' : '' }}>{{ $i }} places</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom du chauffeur *</label>
                            <input type="text" name="chauffeur_nom" class="form-control @error('chauffeur_nom') is-invalid @enderror"
                                   value="{{ old('chauffeur_nom') }}" placeholder="Ex : Mohammed Tazi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone chauffeur *</label>
                            <input type="text" name="chauffeur_tel" class="form-control @error('chauffeur_tel') is-invalid @enderror"
                                   value="{{ old('chauffeur_tel') }}" placeholder="Ex : +212 6XX XX XX XX" required>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-amber btn-lg w-100">
                        <i class="bi bi-check2-circle"></i> Créer le trajet
                    </button>
                    <a href="{{ route('courtier.trajets.index') }}" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
