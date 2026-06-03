@extends('layout')
@section('titre', 'Réservations du trajet')
@section('contenu')

<div class="container py-4">
    <a href="{{ route('courtier.trajets.show', $trajet) }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour au trajet
    </a>

    <div class="card p-4">
        <h4 class="mb-3">
            <i class="bi bi-people"></i>
            Réservations — {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
            <span class="badge bg-brand-navy ms-2">{{ $trajet->heure_depart->format('d/m H:i') }}</span>
        </h4>

        <ul class="nav nav-tabs mb-3" id="reservationTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#confirmees" type="button">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    Confirmées ({{ $confirmees->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attente" type="button">
                    <i class="bi bi-hourglass-split text-warning"></i>
                    En attente ({{ $enAttente->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="confirmees">
                @if($confirmees->isEmpty())
                    <p class="text-muted text-center py-3">Aucune réservation confirmée.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr><th>#</th><th>Voyageur</th><th>Téléphone</th><th>Email</th><th>Payé</th><th>Réservé le</th></tr>
                            </thead>
                            <tbody>
                                @foreach($confirmees as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="fw-semibold">{{ $r->user->name }}</td>
                                    <td>{{ $r->user->telephone ?? '—' }}</td>
                                    <td>{{ $r->user->email }}</td>
                                    <td>
                                        @if($r->paye)
                                            <span class="badge badge-green"><i class="bi bi-credit-card"></i> Payé</span>
                                        @else
                                            <span class="badge badge-gray">Non</span>
                                        @endif
                                    </td>
                                    <td class="small">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="tab-pane fade" id="attente">
                @if($enAttente->isEmpty())
                    <p class="text-muted text-center py-3">Aucune personne en attente.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr><th>Position</th><th>Voyageur</th><th>Téléphone</th><th>Email</th></tr>
                            </thead>
                            <tbody>
                                @foreach($enAttente as $r)
                                <tr>
                                    <td><span class="badge bg-dark">#{{ $r->position_file }}</span></td>
                                    <td class="fw-semibold">{{ $r->user->name }}</td>
                                    <td>{{ $r->user->telephone ?? '—' }}</td>
                                    <td>{{ $r->user->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
