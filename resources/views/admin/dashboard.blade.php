@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Stats Cards Row -->
    <div class="dashboard-stats">
        <!-- Users Card -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-title">Toplam Kullanıcılar</div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="text-xs">
                    <span class="text-success mr-2">{{ $customerCount }} Müşteri</span>
                    <span class="text-info">{{ $realtorCount }} Emlakçı</span>
                </div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
        </div>

        <!-- Villas Card -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-title">Toplam Villalar</div>
                <div class="stat-value">{{ $totalVillas }}</div>
                <div class="text-xs">
                    <span class="text-success mr-2">{{ $activeVillas }} Aktif</span>
                    <span class="text-info">{{ $featuredVillas }} Öne Çıkan</span>
                </div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-home fa-2x text-gray-300"></i>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-title">Toplam Rezervasyonlar</div>
                <div class="stat-value">{{ $totalBookings }}</div>
                <div class="text-xs">
                    <span class="text-warning mr-2">{{ $pendingBookings }} Bekleyen</span>
                    <span class="text-success">{{ $confirmedBookings }} Onaylı</span>
                </div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
            </div>
        </div>

        <!-- Cancellations Card -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-title">İptal Edilen Rezervasyonlar</div>
                <div class="stat-value">{{ $cancelledBookings }}</div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Stats -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Aylık İstatistikler ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr class="bg-light">
                                    <th>Ay</th>
                                    <th class="text-center">Rezervasyon Sayısı</th>
                                    <th class="text-center">Toplam Gelir</th>
                                    <th class="text-center">Ortalama Gelir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $months = [
                                        1 => 'Ocak', 2 => 'Şubat', 3 => 'Mart', 4 => 'Nisan',
                                        5 => 'Mayıs', 6 => 'Haziran', 7 => 'Temmuz', 8 => 'Ağustos',
                                        9 => 'Eylül', 10 => 'Ekim', 11 => 'Kasım', 12 => 'Aralık'
                                    ];
                                @endphp
                                
                                @foreach($months as $monthNum => $monthName)
                                    <tr>
                                        <td>{{ $monthName }}</td>
                                        <td class="text-center">
                                            {{ $monthlyBookingsData[$monthNum] ?? 0 }}
                                            @if(($monthlyBookingsData[$monthNum] ?? 0) > 0)
                                                <span class="text-success">
                                                    <i class="fas fa-arrow-up"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($monthlyRevenueData[$monthNum] ?? 0, 0, ',', '.') }} ₺
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $bookings = $monthlyBookingsData[$monthNum] ?? 0;
                                                $revenue = $monthlyRevenueData[$monthNum] ?? 0;
                                                $average = $bookings > 0 ? $revenue / $bookings : 0;
                                            @endphp
                                            {{ number_format($average, 0, ',', '.') }} ₺
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Son Rezervasyonlar</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Villa</th>
                                    <th>Müşteri</th>
                                    <th>Tarih</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>
                                        <a href="{{ route('villas.show', $booking->villa->slug) }}" class="font-weight-bold text-primary">
                                            {{ $booking->villa->title }}
                                        </a>
                                    </td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}</td>
                                    <td>{{ number_format($booking->total_price, 0, ',', '.') }} ₺</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge badge-warning">Bekliyor</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge badge-success">Onaylandı</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge badge-primary">Tamamlandı</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge badge-danger">İptal</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Henüz rezervasyon bulunmuyor.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.bookings') }}" class="btn btn-primary btn-sm">Tüm Rezervasyonları Görüntüle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dashboard initialization
        console.log('Admin dashboard loaded successfully');
    });
</script>
@endsection
