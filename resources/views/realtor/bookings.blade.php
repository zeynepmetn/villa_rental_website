@extends('layouts.realtor')

@section('title', 'Rezervasyonlar')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rezervasyonlar</h1>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('realtor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Rezervasyonlar</li>
    </ol>

    <!-- Filtreleme -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtrele</h6>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" class="filter-form">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="search" class="form-label">Arama</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Rezervasyon No, Villa adı veya Müşteri">
                    </div>
                    
                    <div class="filter-item">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Tümü</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Bekleyen</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Onaylanan</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlanan</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal Edilen</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="date_from" class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>

                    <div class="filter-item">
                        <label for="date_to" class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>

                <div class="filter-row">
                    <div class="filter-item">
                        <label for="sort" class="form-label">Sıralama</label>
                        <select class="form-control" id="sort" name="sort">
                            <option value="created_desc" {{ request('sort', 'created_desc') == 'created_desc' ? 'selected' : '' }}>Rezervasyon Tarihi (Yeni)</option>
                            <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>Rezervasyon Tarihi (Eski)</option>
                            <option value="checkin_desc" {{ request('sort') == 'checkin_desc' ? 'selected' : '' }}>Giriş Tarihi (Yeni)</option>
                            <option value="checkin_asc" {{ request('sort') == 'checkin_asc' ? 'selected' : '' }}>Giriş Tarihi (Eski)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fiyat (Yüksek)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fiyat (Düşük)</option>
                        </select>
                    </div>
                    
                    <div class="filter-item">
                        <!-- Boş alan -->
                    </div>
                    
                    <div class="filter-item">
                        <!-- Boş alan -->
                    </div>
                    
                    <div class="filter-item">
                        <!-- Boş alan -->
                    </div>
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrele
                    </button>
                    <a href="{{ route('realtor.bookings') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Temizle
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Toplam Rezervasyon</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBookings }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bekleyen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingBookings }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Onaylanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $confirmedBookings }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Toplam Gelir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalRevenue, 0, ',', '.') }} ₺
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rezervasyon Listesi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rezervasyon No</th>
                            <th>Villa</th>
                            <th>Müşteri</th>
                            <th>Tarih Aralığı</th>
                            <th>Misafir Sayısı</th>
                            <th>Toplam Fiyat</th>
                            <th>Durum</th>
                            <th>Rezervasyon Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>
                                <span class="font-weight-bold">#{{ $booking->id }}</span>
                            </td>
                            <td>
                                <div>
                                    <div class="font-weight-bold">{{ $booking->villa->title }}</div>
                                    <small class="text-muted">{{ $booking->villa->location->name }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="font-weight-bold">{{ $booking->customer->name }}</div>
                                    <small class="text-muted">{{ $booking->customer->email }}</small>
                                    @if($booking->customer->phone)
                                        <br><small class="text-muted">{{ $booking->customer->phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>Giriş:</strong> {{ $booking->check_in->format('d.m.Y') }}<br>
                                    <strong>Çıkış:</strong> {{ $booking->check_out->format('d.m.Y') }}<br>
                                    <small class="text-muted">{{ $booking->check_in->diffInDays($booking->check_out) }} gece</small>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-users mr-1"></i>
                                {{ $booking->guests }}
                            </td>
                            <td>
                                <span class="font-weight-bold text-success">
                                    {{ number_format($booking->total_price, 0, ',', '.') }} ₺
                                </span>
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge badge-warning">Bekleyen</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge badge-success">Onaylandı</span>
                                @elseif($booking->status == 'cancelled')
                                    <span class="badge badge-danger">İptal Edildi</span>
                                @elseif($booking->status == 'completed')
                                    <span class="badge badge-info">Tamamlandı</span>
                                @endif
                            </td>
                            <td>
                                {{ $booking->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td>
                                <div class="d-flex" style="gap: 5px;">
                                    <!-- 1. Pozisyon: Onayla butonu (sadece pending) -->
                                    @if($booking->status == 'pending')
                                        <button type="button" 
                                                class="btn btn-success btn-sm" 
                                                onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')"
                                                title="Onayla"
                                                style="width: 38px;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <div style="width: 38px;"></div>
                                    @endif
                                    
                                    <!-- 2. Pozisyon: İptal Et butonu (sadece pending) -->
                                    @if($booking->status == 'pending')
                                        <button type="button" 
                                                class="btn btn-danger btn-sm" 
                                                onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')"
                                                title="İptal Et"
                                                style="width: 38px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <div style="width: 38px;"></div>
                                    @endif
                                    
                                    <!-- 3. Pozisyon: Tamamla butonu (sadece confirmed) -->
                                    @if($booking->status == 'confirmed')
                                        <button type="button" 
                                                class="btn btn-info btn-sm" 
                                                onclick="updateBookingStatus({{ $booking->id }}, 'completed')"
                                                title="Tamamlandı Olarak İşaretle"
                                                style="width: 38px;">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                    @else
                                        <div style="width: 38px;"></div>
                                    @endif
                                    
                                    <!-- 4. Pozisyon: Detay butonu (her zaman var) -->
                                    <button type="button" 
                                            class="btn btn-primary btn-sm" 
                                            onclick="showBookingDetails({{ $booking->id }})"
                                            title="Detayları Görüntüle"
                                            style="width: 38px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Booking Details Modal -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rezervasyon Detayları</h5>
            </div>
            <div class="modal-body" id="bookingDetailsContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeBookingModal()">Kapat</button>
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

.filter-form {
    margin-bottom: 1.5rem;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.filter-item {
    flex: 1;
    min-width: 200px;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

/* Filtreleme kutularının yüksekliği */
.filter-form .form-control {
    height: calc(2.5em + 0.75rem + 2px) !important;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
}

.filter-form .form-label {
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.text-gray-800 {
    color: #5a5c69 !important;
}
</style>
@endsection

@section('scripts')
<script>
function updateBookingStatus(bookingId, status) {
    let confirmMessage = '';
    
    switch(status) {
        case 'confirmed':
            confirmMessage = 'Bu rezervasyonu onaylamak istediğinizden emin misiniz?';
            break;
        case 'cancelled':
            confirmMessage = 'Bu rezervasyonu iptal etmek istediğinizden emin misiniz?';
            break;
        case 'completed':
            confirmMessage = 'Bu rezervasyonu tamamlandı olarak işaretlemek istediğinizden emin misiniz?';
            break;
    }
    
    if (confirm(confirmMessage)) {
        fetch(`/realtor/bookings/${bookingId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('İşlem sırasında bir hata oluştu: ' + (data.message || 'Bilinmeyen hata'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('İşlem sırasında bir hata oluştu.');
        });
    }
}

function showBookingDetails(bookingId) {
    fetch(`/realtor/bookings/${bookingId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const booking = data.booking;
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Rezervasyon Bilgileri</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Rezervasyon No:</strong></td>
                                    <td>#${booking.id}</td>
                                </tr>
                                <tr>
                                    <td><strong>Durum:</strong></td>
                                    <td>
                                        ${booking.status == 'pending' ? '<span class="badge badge-warning">Bekleyen</span>' : ''}
                                        ${booking.status == 'confirmed' ? '<span class="badge badge-success">Onaylandı</span>' : ''}
                                        ${booking.status == 'cancelled' ? '<span class="badge badge-danger">İptal Edildi</span>' : ''}
                                        ${booking.status == 'completed' ? '<span class="badge badge-info">Tamamlandı</span>' : ''}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Giriş Tarihi:</strong></td>
                                    <td>${booking.check_in}</td>
                                </tr>
                                <tr>
                                    <td><strong>Çıkış Tarihi:</strong></td>
                                    <td>${booking.check_out}</td>
                                </tr>
                                <tr>
                                    <td><strong>Misafir Sayısı:</strong></td>
                                    <td>${booking.guests}</td>
                                </tr>
                                <tr>
                                    <td><strong>Toplam Fiyat:</strong></td>
                                    <td><strong class="text-success">${booking.total_price} ₺</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Müşteri Bilgileri</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Ad Soyad:</strong></td>
                                    <td>${booking.customer.name}</td>
                                </tr>
                                <tr>
                                    <td><strong>E-posta:</strong></td>
                                    <td>${booking.customer.email}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telefon:</strong></td>
                                    <td>${booking.customer.phone || 'Belirtilmemiş'}</td>
                                </tr>
                            </table>
                            
                            <h6>Villa Bilgileri</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Villa Adı:</strong></td>
                                    <td>${booking.villa.title}</td>
                                </tr>
                                <tr>
                                    <td><strong>Konum:</strong></td>
                                    <td>${booking.villa.location.name}</td>
                                </tr>
                                <tr>
                                    <td><strong>Adres:</strong></td>
                                    <td>${booking.villa.address}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    ${booking.special_requests ? `
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Özel İstekler</h6>
                                <p class="bg-light p-3 rounded">${booking.special_requests}</p>
                            </div>
                        </div>
                    ` : ''}
                `;
                
                document.getElementById('bookingDetailsContent').innerHTML = content;
                $('#bookingDetailsModal').modal('show');
            } else {
                alert('Rezervasyon detayları yüklenirken bir hata oluştu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Rezervasyon detayları yüklenirken bir hata oluştu.');
        });
}

function closeBookingModal() {
    $('#bookingDetailsModal').modal('hide');
}

// No DataTable initialization needed - using Laravel pagination
</script>
@endsection 