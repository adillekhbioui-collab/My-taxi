<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My-Taxi — @yield('titre', 'Authentification')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand-navy: #0f172a; --brand-amber: #f59e0b; --brand-amber-light: #fbbf24; }
        body { font-family: 'Jost', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center;
               background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 2rem 1rem; }
        .auth-card { background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 16px 48px rgba(0,0,0,0.3); width: 100%; max-width: 440px; }
        .auth-card .brand { font-size: 1.75rem; font-weight: 800; color: var(--brand-navy); text-decoration: none; letter-spacing: -0.5px; }
        .auth-card .brand i { color: var(--brand-amber); }
        .auth-card .form-control:focus { border-color: var(--brand-amber); box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25); }
        .btn-amber { background-color: var(--brand-amber); border-color: var(--brand-amber); color: #0f172a; font-weight: 600; }
        .btn-amber:hover { background-color: var(--brand-amber-light); color: #0f172a; }
        .form-label { font-weight: 600; font-size: 0.9rem; }
        h2 { font-weight: 700; letter-spacing: -0.3px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="brand"><i class="bi bi-taxi-front"></i> My-Taxi</a>
        </div>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger py-2 small">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif
        {{ $slot }}
    </div>
</body>
</html>
