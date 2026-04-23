<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #1e40af, #10b981);">
                    <div class="container">
                        <a class="navbar-brand fw-bold" href="/">
                            <span class="text-success">Aspirasi</span>Desa
                        </a>
                        <div class="navbar-nav ms-auto flex-row align-items-center gap-2">
                            @if(Auth::check())
                                <span class="navbar-text text-white me-3">Hi, {{ Auth::user()->name }}</span>
                                <a class="nav-link" href="{{ route('aspirasi.index') }}">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-light ms-2" type="submit">Logout</button>
                                </form>
                            @else
                                <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                                <a class="btn btn-light ms-2" href="{{ route('register') }}">Daftar Gratis</a>
                            @endif
                        </div>
                    </div>
                </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

             <main class="container py-4 min-vh-75">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="bg-dark text-white text-center py-4 mt-5">
                <div class="container">
                    <p class="mb-0">&copy; 2024 AspirasiDesa.
                </div>
            </footer>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </div>
    </body>
</html>



