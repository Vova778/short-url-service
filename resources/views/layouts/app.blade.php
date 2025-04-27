<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', __('messages.app_name'))</title>
  @vite(['resources/js/app.js','resources/sass/app.scss'])
  @stack('styles')
</head>
<body>
  @include('partials.navbar')
  <main class="container py-4">
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @yield('content')
  </main>
  @stack('scripts')
</body>
</html>
