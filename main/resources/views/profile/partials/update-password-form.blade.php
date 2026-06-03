<section>
    <h4 class="mb-3"><i class="bi bi-lock text-warning"></i> Mot de passe</h4>
    <p class="text-muted small mb-4">Utilisez un mot de passe long et sécurisé.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf @method('put')

        <div class="mb-3">
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            @error('current_password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
            @error('password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-amber">Enregistrer</button>
            @if(session('status') === 'password-updated')
                <span class="small text-success"><i class="bi bi-check-circle"></i> Enregistré</span>
            @endif
        </div>
    </form>
</section>
