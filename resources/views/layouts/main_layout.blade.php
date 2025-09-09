<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoinDeal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            color: #ffffff;
            min-height: 100vh;
        }

        /* Navbar cinza escuro */
        .navbar {
            background-color: #2d3949 !important; 
        }

        .navbar .navbar-brand img {
            height: 40px; 
        }

        .navbar .nav-link {
            color: #ffffff !important;
        }

        .navbar .nav-link.active {
            border-bottom: 2px solid #38BDF8;
        }

        .btn-primary {
            background-color: #7C3AED;
            border: none;
        }
        .btn-primary:hover {
            background-color: #6D28D9;
        }

        .btn-outline-light {
            color: #38BDF8;
            border-color: #38BDF8;
        }
        .btn-outline-light:hover {
            background-color: #38BDF8;
            color: #334155;
        }

        .card {
            background-color: rgba(30, 41, 59, 0.9);
            color: #ffffff;
            border-radius: 1rem;
        }

        .form-control {
            background-color: #334155;
            color: #ffffff;
            border: 1px solid #475569;
        }
        .form-control:focus {
            border-color: #7C3AED;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
        }

        .invalid-feedback {
            color: #F87171;
        }

        /* Homepage (cinza escuro) */
        .home-bg {
            background-color: #334155; 
            min-height: 100vh;
        }

        /* Login e Registro (gradiente roxo -> azul claro) */
        .auth-bg {
            background: linear-gradient(135deg, #7C3AED, #38BDF8); 
            min-height: 100vh;
        }
    </style>
</head>
<body class="{{ request()->routeIs('home') ? 'home-bg' : 'auth-bg' }}">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-joindeal.png') }}" alt="JoinDeal Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Cadastrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <main class="pt-5 mt-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
