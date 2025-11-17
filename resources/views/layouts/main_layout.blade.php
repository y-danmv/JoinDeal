<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoinDeal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* (Seu CSS original permanece o mesmo) */
        body {
            color: #ffffff;
            min-height: 100vh;
        }
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
            border: none; 
        }
        .form-control, .form-select { 
            background-color: #334155;
            color: #ffffff;
            border: 1px solid #475569;
        }
        .form-control:focus, .form-select:focus { 
            border-color: #7C3AED;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
            background-color: #334155; 
            color: #ffffff; 
        }
        .form-select option { 
             background-color: #334155;
             color: #ffffff;
        }
        .form-control::placeholder { 
            color: #9ca3af;
        }
        .invalid-feedback {
            color: #F87171;
        }
        .home-bg {
            background-color: #334155; 
            min-height: 100vh;
        }
        .auth-bg {
            background: linear-gradient(135deg, #7C3AED, #38BDF8); 
            min-height: 100vh;
        }
        .alert-success-custom {
            background-color: #38BDF8 !important;
            color: #FFFFFF !important;
            border: 1px solid #334155 !important;
            font-weight: bold;
        }
        .alert-error-custom, .alert-danger { 
            background-color: #F87171 !important; 
            color: #FFFFFF !important;
            border: 1px solid #334155 !important; 
            font-weight: bold;
        }
        .alert button.btn-close {
            filter: invert(1); 
        }
    </style>
</head>
<body class="{{ request()->routeIs('home') ? 'home-bg' : 'auth-bg' }}">
    
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
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Olá, {{ Auth::user()->nome }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                
                                <li><a class="dropdown-item" href="{{ route('services.index') }}">Ver Serviços</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Agendamentos</a></li>
                                
                                @if (Auth::user()->tipo == 'Prestador')
                                <li><a class="dropdown-item" href="{{ route('services.create') }}">Anunciar</a></li>
                                @endif

                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">Meu Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Sair (Logout)</a></li>
                            </ul>
                        </li>

                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Cadastrar</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="pt-5 mt-5 container"> @if(session('success'))
            <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Ocorreram erros de validação:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>