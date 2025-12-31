@extends('layouts.realtor')

@section('title', 'Emlakçı Paneli')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Emlakçı Paneli</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Villas Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Toplam Villalar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $villasCount }}</div>
                            <div class="text-xs">
                                <span class="text-success mr-2">{{ $activeVillasCount }} Aktif</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Toplam Rezervasyonlar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bookingsCount }}</div>
                            <div class="text-xs">
                                <span class="text-warning mr-2">{{ $pendingBookingsCount }} Bekleyen</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bu Yıl Gelir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(array_sum($monthlyRevenueData), 0, ',', '.') }} ₺
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Ortalama Gelir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalRevenue = array_sum($monthlyRevenueData);
                                    $average = $bookingsCount > 0 ? $totalRevenue / $bookingsCount : 0;
                                @endphp
                                {{ number_format($average, 0, ',', '.') }} ₺
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Monthly Revenue Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Aylık Gelir Grafiği</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Son Rezervasyonlar</h6>
                </div>
                <div class="card-body">
                    @forelse($recentBookings as $booking)
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            @if($booking->status == 'pending')
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                            @elseif($booking->status == 'confirmed')
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            @else
                                <div class="icon-circle bg-secondary">
                                    <i class="fas fa-times text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-gray-500">{{ $booking->created_at->format('d.m.Y') }}</div>
                            <div class="font-weight-bold">{{ $booking->villa->title }}</div>
                            <div class="small">{{ $booking->customer->name }}</div>
                            <div class="small text-primary">{{ number_format($booking->total_price, 0, ',', '.') }} ₺</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Henüz rezervasyon yok.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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

.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-area {
    position: relative;
    height: 10rem;
    width: 100%;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 
                'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: 'Gelir (₺)',
            data: @json(array_values($monthlyRevenueData)),
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('tr-TR').format(value) + ' ₺';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Gelir: ' + new Intl.NumberFormat('tr-TR').format(context.parsed.y) + ' ₺';
                    }
                }
            }
        }
    }
});
</script>
@endsection 