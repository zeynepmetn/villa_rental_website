@extends('layouts.customer')

@section('title', 'Dashboard - VillaLand')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <!-- Total Bookings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Toplam Rezervasyon
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBookings ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Bookings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tamamlanan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedBookings ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favorite Villas Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Favori Villa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $favoriteCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-heart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Değerlendirme
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReviews ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hızlı İşlemler</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('villas.index') }}" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-search mb-2"></i><br>
                                Villa Ara
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('customer.bookings') }}" class="btn btn-success btn-block btn-lg">
                                <i class="fas fa-calendar-alt mb-2"></i><br>
                                Rezervasyonlarım
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('customer.favorites') }}" class="btn btn-info btn-block btn-lg">
                                <i class="fas fa-heart mb-2"></i><br>
                                Favorilerim
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('customer.profile') }}" class="btn btn-warning btn-block btn-lg">
                                <i class="fas fa-user-cog mb-2"></i><br>
                                Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Son Rezervasyonlar</h6>
                    <a href="{{ route('customer.bookings') }}" class="btn btn-primary btn-sm">Tümünü Gör</a>
                </div>
                <div class="card-body">
                    @if(isset($recentBookings) && $recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Villa</th>
                                    <th>Tarih</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $booking->villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80' }}" 
                                                 alt="{{ $booking->villa->title }}" class="rounded mr-2" width="40" height="40">
                                            <div>
                                                <div class="font-weight-bold">{{ $booking->villa->title }}</div>
                                                <small class="text-muted">{{ $booking->villa->address }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $booking->check_in->format('d.m.Y') }}<br>
                                            {{ $booking->check_out->format('d.m.Y') }}
                                        </small>
                                    </td>
                                    <td>₺{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @switch($booking->status)
                                            @case('pending')
                                                <span class="badge badge-warning">Bekliyor</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge badge-success">Onaylandı</span>
                                                @break
                                            @case('active')
                                                <span class="badge badge-info">Aktif</span>
                                                @break
                                            @case('completed')
                                                <span class="badge badge-success">Tamamlandı</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-danger">İptal</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.bookings.show', $booking->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">Henüz rezervasyonunuz yok</h5>
                        <p class="text-gray-500">İlk villa rezervasyonunuzu yapmak için villa arama sayfasını ziyaret edin.</p>
                        <a href="{{ route('villas.index') }}" class="btn btn-primary">
                            <i class="fas fa-search mr-2"></i>Villa Ara
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Özeti</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=667eea&color=fff&size=100' }}" 
                         alt="{{ Auth::user()->name }}" class="rounded-circle mb-3" width="80" height="80">
                    <h5 class="font-weight-bold">{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <small class="text-muted">Üye: {{ Auth::user()->created_at->format('M Y') }}</small>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="h5 font-weight-bold text-primary">{{ $totalBookings ?? 0 }}</div>
                            <small class="text-muted">Rezervasyon</small>
                        </div>
                        <div class="col-4">
                            <div class="h5 font-weight-bold text-success">{{ $completedBookings ?? 0 }}</div>
                            <small class="text-muted">Tamamlanan</small>
                        </div>
                        <div class="col-4">
                            <div class="h5 font-weight-bold text-info">{{ $favoriteCount ?? 0 }}</div>
                            <small class="text-muted">Favori</small>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <a href="{{ route('customer.profile') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-user-edit mr-2"></i>Profili Düzenle
                    </a>
                </div>
            </div>

            <!-- Favorite Villas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Favori Villalar</h6>
                    <a href="{{ route('customer.favorites') }}" class="btn btn-primary btn-sm">Tümünü Gör</a>
                </div>
                <div class="card-body">
                    @if(isset($favoriteVillas) && $favoriteVillas->count() > 0)
                    @foreach($favoriteVillas->take(3) as $villa)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80' }}" 
                             alt="{{ $villa->title }}" class="rounded mr-3" width="50" height="50">
                        <div class="flex-grow-1">
                            <div class="font-weight-bold">{{ $villa->title }}</div>
                            <small class="text-muted">{{ $villa->address }}</small>
                            <div class="text-primary font-weight-bold">₺{{ number_format($villa->price_per_night, 0, ',', '.') }}/gece</div>
                        </div>
                        <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @if(!$loop->last)<hr>@endif
                    @endforeach
                    @else
                    <div class="text-center py-3">
                        <i class="fas fa-heart fa-2x text-gray-300 mb-2"></i>
                        <p class="text-gray-500 mb-0">Henüz favori villanız yok</p>
                        <a href="{{ route('villas.index') }}" class="btn btn-primary btn-sm mt-2">
                            Villa Keşfet
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Admin-style cards */
.card {
    border: none;
    border-radius: 0.35rem;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-primary {
    color: #5a5c69 !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-600 {
    color: #858796 !important;
}

.text-gray-500 {
    color: #b7b9cc !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.3rem;
    text-align: center;
}

.btn-lg i {
    display: block;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-item.active {
    color: #858796;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
    background-color: #f8f9fc;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.badge-warning {
    background-color: #f6c23e;
    color: #fff;
}

.badge-success {
    background-color: #1cc88a;
    color: #fff;
}

.badge-info {
    background-color: #36b9cc;
    color: #fff;
}

.badge-danger {
    background-color: #e74a3b;
    color: #fff;
}

.badge-secondary {
    background-color: #858796;
    color: #fff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-lg {
        padding: 0.5rem;
        font-size: 0.9rem;
    }
    
    .btn-lg i {
        font-size: 1.2rem;
        margin-bottom: 0.25rem;
    }
    
    .h3 {
        font-size: 1.5rem;
    }
}
</style>
@endpush 