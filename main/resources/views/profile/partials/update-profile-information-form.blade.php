<section>
    <h4 class="mb-3"><i class="bi bi-person-circle text-brand-amber"></i> Informations du profil</h4>
    <p class="text-muted small mb-4">Mettez à jour vos informations personnelles.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-muted">Votre email n'est pas vérifié.
                        <button form="send-verification" class="btn btn-sm btn-link p-0">Renvoyer l'email</button>
                    </p>
                    @if(session('status') === 'verification-link-sent')
                        <p class="small text-success">Un nouveau lien a été envoyé.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input id="telephone" name="telephone" type="text" class="form-control" value="{{ old('telephone', $user->telephone) }}" placeholder="+212 6XX XX XX XX">
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-amber">Enregistrer</button>
            @if(session('status') === 'profile-updated')
                <span class="small text-success"><i class="bi bi-check-circle"></i> Enregistré</span>
            @endif
        </div>
    </form>
</section>
