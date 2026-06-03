<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My-Taxi — @yield('titre', 'Réservation de Taxis')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --brand-navy: #0f172a;
            --brand-amber: #f59e0b;
            --brand-amber-light: #fbbf24;
            --brand-orange: #f97316;
        }
        body {
            font-family: 'Jost', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .navbar-brand i {
            color: var(--brand-amber);
        }
        .bg-brand-navy {
            background-color: var(--brand-navy) !important;
        }
        .text-brand-amber {
            color: var(--brand-amber) !important;
        }
        .btn-amber {
            background-color: var(--brand-amber);
            border-color: var(--brand-amber);
            color: #0f172a;
            font-weight: 600;
        }
        .btn-amber:hover {
            background-color: var(--brand-amber-light);
            border-color: var(--brand-amber-light);
            color: #0f172a;
        }
        .btn-outline-amber {
            border-color: var(--brand-amber);
            color: var(--brand-amber);
        }
        .btn-outline-amber:hover {
            background-color: var(--brand-amber);
            color: #0f172a;
        }
        .card {
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-radius: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .stat-card {
            border-radius: 16px;
            padding: 1.5rem;
            border: none;
        }
        .stat-card .stat-icon {
            font-size: 2rem;
            opacity: 0.2;
        }
        .badge-amber {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-blue {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-gray {
            background-color: #f1f5f9;
            color: #475569;
        }
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 0 0 48px 48px;
            padding: 4rem 0;
        }
        .search-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.15);
            margin-top: -2rem;
        }
        .ride-card {
            border-left: 5px solid var(--brand-amber);
            transition: all 0.2s;
        }
        .ride-card:hover {
            border-left-color: var(--brand-orange);
        }
        footer {
            background: var(--brand-navy);
            color: #94a3b8;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        .section-title {
            position: relative;
            display: inline-block;
        }
        .section-title:after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: var(--brand-amber);
            border-radius: 2px;
            margin-top: 8px;
        }
        .flash-container .alert {
            border-radius: 12px;
            border: none;
        }
        .amount {
            font-weight: 700;
            color: #0f172a;
        }
        .seat-progress {
            height: 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-brand-navy navbar-dark py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-taxi-front"></i> My-Taxi
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('trajets.index') }}">
                        <i class="bi bi-search"></i> Trajets
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reservations.mes') }}">
                        <i class="bi bi-ticket-perforated"></i> Mes réservations
                    </a>
                </li>
                @endauth
            </ul>
            <ul class="navbar-nav">
                @auth
                    @if(auth()->user()->isCourtier())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('courtier.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Courtier
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-amber btn-sm" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="flash-container container mt-3">
    @if(session('succes'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('succes') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('erreur'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('erreur') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('promotion'))
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center">
            <i class="bi bi-megaphone-fill me-2"></i> {{ session('promotion') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<main>
    @yield('contenu')
</main>

<footer class="mt-5 py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; {{ date('Y') }} My-Taxi — Réservation de taxis longue distance</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
