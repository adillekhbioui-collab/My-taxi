<x-guest-layout>
    <h2 class="text-center mb-3">Inscription</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input id="telephone" type="text" name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="+212 6XX XX XX XX">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-amber w-100">S'inscrire</button>
        <p class="text-center text-muted small mt-3 mb-0">
            Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </form>
</x-guest-layout>
