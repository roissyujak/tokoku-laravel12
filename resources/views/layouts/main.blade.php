<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TokoKu') — TokoKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🛒 TokoKu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Produk</a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                            </li>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isSeller())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.create') }}">+ Tambah Produk</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link text-light">
                                Halo, {{ auth()->user()->name }}
                                <span class="badge bg-light text-primary">{{ auth()->user()->role }}</span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-light btn-sm ms-2">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="container mt-3">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif
        @if(session('error'))
            <x-alert type="danger" :message="session('error')" />
        @endif
    </div>

    {{-- Content --}}
    <main class="container my-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; {{ date('Y') }} TokoKu — Proyek Buku Ajar Laravel 12</p>
        <small class="text-muted">Program Studi Teknologi Informasi — UIN Salatiga</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
