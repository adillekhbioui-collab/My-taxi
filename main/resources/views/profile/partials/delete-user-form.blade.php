<section>
    <h4 class="mb-3 text-danger"><i class="bi bi-trash"></i> Supprimer le compte</h4>
    <p class="text-muted small mb-3">Une fois supprimé, toutes les données seront définitivement effacées.</p>

    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
        <i class="bi bi-exclamation-triangle"></i> Supprimer mon compte
    </button>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle"></i> Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="small">Entrez votre mot de passe pour confirmer la suppression définitive de votre compte.</p>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Mot de passe">
                        @error('password', 'userDeletion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
