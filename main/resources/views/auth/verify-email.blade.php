<x-guest-layout>
    <h2 class="text-center mb-3">Vérifiez votre email</h2>
    <p class="text-muted small text-center">Merci de vous être inscrit ! Avant de commencer, vérifiez votre email en cliquant sur le lien que nous vous avons envoyé.</p>
    @if(session('status') === 'verification-link-sent')
        <div class="alert alert-success small">Un nouveau lien a été envoyé à l'adresse email utilisée lors de l'inscription.</div>
    @endif
    <div class="d-flex justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-amber btn-sm">Renvoyer l'email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">Se déconnecter</button>
        </form>
    </div>
</x-guest-layout>
