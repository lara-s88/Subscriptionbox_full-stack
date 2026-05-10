@php
    // Check if the admins table exists before querying it to avoid errors
    $loggedInAdmin    = \Illuminate\Support\Facades\Schema::hasTable('admins') && auth('admin')->check();
    $loggedInCustomer = auth('web')->check();
    $isLoggedIn       = $loggedInAdmin || $loggedInCustomer;

    // Send admin to admin dashboard, customers to normal dashboard
    $dashboardUrl = $loggedInAdmin ? route('admin.dashboard') : route('dashboard');
    $rewardUrl    = $loggedInAdmin ? route('admin.reward') : route('reward');
@endphp

<nav class="navbar navbar-expand-lg fixed-top py-3">
    <div class="container">

        <!-- Brand logo -->
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            <i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox
        </a>

        <!-- Mobile hamburger button -->
        <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#main-nav-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-nav-menu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                @if ($loggedInAdmin)
                    {{-- Admin navigation --}}
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $activePage == 'dashboard' ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $activePage == 'reward' ? 'active' : '' }}"
                            href="{{ route('admin.reward') }}">Rewards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $activePage == 'plans' ? 'active' : '' }}"
                            href="{{ route('admin.plans') }}">Plans</a>
                    </li>
                @else
                    {{-- Customer / public navigation --}}
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold {{ $activePage == 'home' ? 'active' : '' }}"
                            href="{{ route('home') }}" data-public-nav>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $activePage == 'sports' ? 'active' : '' }}"
                            href="{{ route('sports') }}" data-public-nav>Sports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $activePage == 'subscriptions' ? 'active' : '' }}"
                            href="{{ route('subscriptions') }}" data-public-nav>Subscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $activePage == 'dashboard' ? 'active' : '' }}"
                            href="{{ $dashboardUrl }}" data-public-nav>Dashboard</a>
                    </li>
                    <li class="nav-item" id="nav-reward-item">
                        <a class="nav-link px-3 {{ $activePage == 'reward' ? 'active' : '' }}"
                            href="{{ $rewardUrl }}">Rewards</a>
                    </li>
                @endif

                @if ($isLoggedIn)
                    <!-- Logout -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="nav-link btn btn-sm btn-outline-primary px-3 ms-lg-2"
                                id="auth-action-btn">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- Login and Register -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-outline-primary px-3 ms-lg-2"
                            href="{{ route('login') }}" id="auth-action-btn">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-primary px-3 ms-lg-1"
                            href="{{ route('register') }}">Register</a>
                    </li>
                @endif

            </ul>
        </div>

    </div>
</nav>

<script>
    // All app routes in one place so  can use them easily
    window.SportBoxRoutes = {
        home:          @json(route('home')),
        sports:        @json(route('sports')),
        subscriptions: @json(route('subscriptions')),
        dashboard:     @json($dashboardUrl),
        login:         @json(route('login')),
        register:      @json(route('register')),
        boxes:         @json(route('boxes')),
        cart:          @json(route('cart')),
        customize:     @json(route('customize')),
        reward:        @json($rewardUrl),
        logout:        @json(route('logout')),
    };

    window.sportBoxRoute = function (name) {
        return window.SportBoxRoutes?.[name] || '/' + name;
    };
</script>