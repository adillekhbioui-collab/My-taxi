<x-guest-layout>
    <h2 class="text-center mb-3">Nouveau mot de passe</h2>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required readonly>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-amber w-100">Réinitialiser</button>
    </form>
</x-guest-layout>
