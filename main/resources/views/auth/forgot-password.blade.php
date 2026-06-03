<x-guest-layout>
    <h2 class="text-center mb-3">Mot de passe oublié</h2>
    <p class="text-muted small text-center">Saisissez votre email et nous vous enverrons un lien de réinitialisation.</p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-amber w-100">Envoyer le lien</button>
        <p class="text-center mt-3 mb-0"><a href="{{ route('login') }}" class="small text-decoration-none">Retour à la connexion</a></p>
    </form>
</x-guest-layout>
