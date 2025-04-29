<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">

    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand" href="{{ LaravelLocalization::localizeURL(route('home')) }}">
            {{ __('messages.app_name') }}
        </a>

        {{-- Toggler --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="{{ __('messages.toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Links --}}
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(LaravelLocalization::getCurrentLocaleName() . '.home') ? 'active' : '' }}"
                        href="{{ LaravelLocalization::localizeURL(route('home')) }}">
                        {{ __('messages.home') }}
                    </a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                            href="{{ LaravelLocalization::localizeURL(route('login')) }}">
                            {{ __('messages.login') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                            href="{{ LaravelLocalization::localizeURL(route('register')) }}">
                            {{ __('messages.register') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ LaravelLocalization::localizeURL(route('dashboard')) }}">
                            {{ __('messages.dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard')}}">
                                    {{ __('messages.dashboard') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('links.bulk.form') }}">
                                    {{ __('messages.bulk') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('messages.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest

                {{-- Language switcher --}}
                <li class="nav-item dropdown ms-3">
                    <a id="langDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                    class="dropdown-item{{ app()->getLocale() === $localeCode ? ' active' : '' }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ strtoupper($localeCode) }} — {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
