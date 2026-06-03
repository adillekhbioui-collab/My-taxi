<x-guest-layout>
    <h2 class="text-center mb-3">Confirmer le mot de passe</h2>
    <p class="text-muted small text-center">Zone sécurisée — veuillez confirmer votre mot de passe.</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-amber w-100">Confirmer</button>
    </form>
</x-guest-layout>
