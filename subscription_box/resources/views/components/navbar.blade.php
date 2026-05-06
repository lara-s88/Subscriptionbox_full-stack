 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg fixed-top py-3">
     <div class="container">
         <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
             <i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox
         </a>
         <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
             <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                 <li class="nav-item"><a class="nav-link px-3 {{ $activePage == 'home' ? 'active' : '' }} fw-semibold" data-public-nav
                         href="{{ route('home') }}">Home</a>
                 </li> 
                                  <li class="nav-item"><a class="nav-link px-3 {{ $activePage == 'sports' ? 'active' : '' }}" data-public-nav
                         href="{{ route('sports') }}">Sports</a></li>
                                 <li class="nav-item"><a class="nav-link px-3 {{ $activePage == 'subscriptions' ? 'active' : '' }}" data-public-nav
                         href="{{ route('subscriptions') }}">Subscriptions</a></li>
                 <li class="nav-item"><a class="nav-link px-3 {{ $activePage == 'dashboard' ? 'active' : '' }}" data-public-nav
                         href="{{ route('dashboard') }}">Dashboard</a></li>
                 <li class="nav-item" id="rewardNavItem"><a class="nav-link px-3" href="{{ route('reward') }}">Rewards</a></li>
                 <li class="nav-item"><a class="nav-link btn btn-sm btn-outline-primary px-3 ms-lg-2"  href="{{ route('login') }}"
                         id="authActionLink">Login</a></li>
                 <li class="nav-item"><a class="nav-link btn btn-sm btn-primary px-3 ms-lg-1" href="{{ route('register') }}">Register</a></li>
                 <li class="nav-item ms-lg-1">
                     <button class="btn btn-sm btn-outline-secondary px-3" id="darkModeToggle"
                         type="button">
                         <i class="bi bi-moon-stars-fill"></i>
                     </button>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
<script>
     window.SportBoxRoutes = {
         home: @json(route('home')),
         sports: @json(route('sports')),
         subscriptions: @json(route('subscriptions')),
         dashboard: @json(route('dashboard')),
         login: @json(route('login')),
         register: @json(route('register')),
         boxes: @json(route('boxes')),
         cart: @json(route('cart')),
         customize: @json(route('customize')),
         reward: @json(route('reward')),
     };
     window.sportBoxRoute = function (name) {
         return window.SportBoxRoutes?.[name] || '/' + name;
     };
 </script>
