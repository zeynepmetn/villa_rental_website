<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="gradient-text font-weight-bold">VillaLand</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('villas.index') ? 'active' : '' }}" href="{{ route('villas.index') }}">Villalar</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Lokasyonlar
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($globalLocations as $location)
                                <li><a class="dropdown-item" href="{{ route('villas.index', ['location' => $location->id]) }}">{{ $location->name }}</a></li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('villas.index') }}">Tüm Lokasyonlar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">İletişim</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sign-in-alt me-1"></i> Giriş
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i> Kayıt
                        </a>
                    @else
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(auth()->user()->profile_image)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="rounded-circle me-2" width="32" height="32">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" alt="{{ auth()->user()->name }}" class="rounded-circle me-2" width="32" height="32">
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                
                                @if(auth()->user()->isCustomer())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.bookings') }}">
                                            <i class="fas fa-calendar-check me-2"></i> Rezervasyonlarım
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.favorites') }}">
                                            <i class="fas fa-heart me-2"></i> Favorilerim
                                        </a>
                                    </li>
                                @endif
                                
                                @if(auth()->user()->isRealtor())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('realtor.villas') }}">
                                            <i class="fas fa-home me-2"></i> Villalarım
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('realtor.bookings') }}">
                                            <i class="fas fa-calendar-check me-2"></i> Rezervasyonlar
                                        </a>
                                    </li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('navLogoutForm').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Çıkış Yap
                                    </a>
                                    <form id="navLogoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
/* Compact Navbar Styles */
.navbar {
    min-height: 70px;
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: 700;
    padding: 0.5rem 0;
}

.navbar-nav .nav-link {
    padding: 0.6rem 0.8rem;
    font-size: 1rem;
    font-weight: 500;
}

.navbar-nav .dropdown-menu {
    margin-top: 0.25rem;
}

.btn {
    padding: 0.5rem 1.2rem;
    font-size: 0.95rem;
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.85rem;
}

/* User dropdown avatar */
.dropdown-toggle img {
    width: 32px;
    height: 32px;
}

/* Mobile responsive */
@media (max-width: 991.98px) {
    .navbar-collapse {
        margin-top: 0.5rem;
    }
    
    .navbar-nav {
        margin-bottom: 1rem;
    }
    
    .navbar-nav .nav-link {
        padding: 0.5rem 0;
    }
    
    /* Force hamburger button styling */
    .navbar-toggler {
        border: 2px solid #6366f1 !important;
        background-color: rgba(99, 102, 241, 0.1) !important;
        padding: 0.4rem 0.5rem !important;
        border-radius: 0.5rem !important;
    }
    
    .navbar-toggler:focus,
    .navbar-toggler:active {
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
        border-color: #6366f1 !important;
        outline: none !important;
    }
    
    .navbar-toggler:hover {
        background-color: rgba(99, 102, 241, 0.2) !important;
        border-color: #4f46e5 !important;
    }
    
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%234f46e5' stroke-linecap='round' stroke-miterlimit='10' stroke-width='4' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        width: 22px !important;
        height: 22px !important;
        filter: none !important;
        opacity: 1 !important;
    }
}
</style>
