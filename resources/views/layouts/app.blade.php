<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('messages.app_name'))</title>

    {{-- Vite --}}
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Navbar --}}
    @include('partials.navbar')

    <main class="flex-fill container my-5">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="{{ __('messages.close') }}"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer mt-auto text-center py-3">
        &copy; {{ date('Y') }} ShortLink {{ __('messages.all_rights_reserved') }}
    </footer>

    @stack('scripts')
</body>

</html>
