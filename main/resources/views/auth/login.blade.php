<x-guest-layout>
    <h2 class="text-center mb-3">Connexion</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label for="remember_me" class="form-check-label">Se souvenir de moi</label>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none">Mot de passe oublié ?</a>
            @endif
            <button type="submit" class="btn btn-amber px-4">Se connecter</button>
        </div>
        <p class="text-center text-muted small mt-3 mb-0">
            Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </p>
    </form>
</x-guest-layout>
