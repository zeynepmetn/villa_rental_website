@extends('layouts.customer')

@section('title', 'Rezervasyonlarım - VillaLand')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Rezervasyonlarım</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rezervasyonlar</li>
            </ol>
        </div>
        <a href="{{ route('villas.index') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Yeni Rezervasyon
        </a>
    </div>

    <!-- Filters -->
    <div class="filters-section mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <select class="form-select" id="statusFilter">
                    <option value="">Tüm Durumlar</option>
                    <option value="pending">Onay Bekliyor</option>
                    <option value="confirmed">Onaylandı</option>
                    <option value="active">Aktif</option>
                    <option value="completed">Tamamlandı</option>
                    <option value="cancelled">İptal Edildi</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" id="dateFilter" placeholder="Tarih Filtresi">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchFilter" placeholder="Villa adı ile ara...">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                    <i class="fas fa-times me-2"></i>Temizle
                </button>
            </div>
        </div>
    </div>

    <!-- Bookings List -->
    @if($activeBookings->count() > 0 || $pastBookings->count() > 0 || $cancelledBookings->count() > 0)
    <div class="bookings-list">
        @foreach($activeBookings as $booking)
        <div class="booking-item" data-status="{{ strtolower($booking->status) }}">
            <div class="booking-card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="booking-image">
                            <img src="{{ $booking->villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $booking->villa->title }}">
                            <div class="booking-status status-{{ strtolower($booking->status) }}">
                                @switch($booking->status)
                                    @case('pending')
                                        <i class="fas fa-clock me-1"></i>Onay Bekliyor
                                        @break
                                    @case('confirmed')
                                        <i class="fas fa-check me-1"></i>Onaylandı
                                        @break
                                    @case('active')
                                        <i class="fas fa-play me-1"></i>Aktif
                                        @break
                                    @case('completed')
                                        <i class="fas fa-check-circle me-1"></i>Tamamlandı
                                        @break
                                    @case('cancelled')
                                        <i class="fas fa-times me-1"></i>İptal Edildi
                                        @break
                                    @default
                                        {{ ucfirst($booking->status) }}
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="booking-content">
                            <div class="booking-header">
                                <h4>{{ $booking->villa->title }}</h4>
                                <div class="booking-id">
                                    <small class="text-muted">#{{ $booking->id }}</small>
                                </div>
                            </div>
                            <div class="booking-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    {{ $booking->villa->location->name }}
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}
                                    <small class="text-muted ms-2">({{ $booking->nights }} gece)</small>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $booking->guests }} Kişi
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    {{ number_format($booking->total_price, 2) }} ₺
                                </div>
                            </div>
                            <div class="booking-actions">
                                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detaylar
                                </a>
                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancelBooking({{ $booking->id }})">
                                    <i class="fas fa-times me-1"></i>İptal Et
                                </button>
                                @endif
                                @if($booking->status === 'completed' && !$booking->hasReview())
                                <a href="{{ route('customer.reviews.create', $booking->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-star me-1"></i>Değerlendir
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($pastBookings as $booking)
        <div class="booking-item" data-status="{{ strtolower($booking->status) }}">
            <div class="booking-card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="booking-image">
                            <img src="{{ $booking->villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $booking->villa->title }}">
                            <div class="booking-status status-{{ strtolower($booking->status) }}">
                                @switch($booking->status)
                                    @case('pending')
                                        <i class="fas fa-clock me-1"></i>Onay Bekliyor
                                        @break
                                    @case('confirmed')
                                        <i class="fas fa-check me-1"></i>Onaylandı
                                        @break
                                    @case('active')
                                        <i class="fas fa-play me-1"></i>Aktif
                                        @break
                                    @case('completed')
                                        <i class="fas fa-check-circle me-1"></i>Tamamlandı
                                        @break
                                    @case('cancelled')
                                        <i class="fas fa-times me-1"></i>İptal Edildi
                                        @break
                                    @default
                                        {{ ucfirst($booking->status) }}
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="booking-content">
                            <div class="booking-header">
                                <h4>{{ $booking->villa->title }}</h4>
                                <div class="booking-id">
                                    <small class="text-muted">#{{ $booking->id }}</small>
                                </div>
                            </div>
                            <div class="booking-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    {{ $booking->villa->location->name }}
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}
                                    <small class="text-muted ms-2">({{ $booking->nights }} gece)</small>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $booking->guests }} Kişi
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    {{ number_format($booking->total_price, 2) }} ₺
                                </div>
                            </div>
                            <div class="booking-actions">
                                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detaylar
                                </a>
                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancelBooking({{ $booking->id }})">
                                    <i class="fas fa-times me-1"></i>İptal Et
                                </button>
                                @endif
                                @if($booking->status === 'completed' && !$booking->hasReview())
                                <a href="{{ route('customer.reviews.create', $booking->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-star me-1"></i>Değerlendir
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($cancelledBookings as $booking)
        <div class="booking-item" data-status="{{ strtolower($booking->status) }}">
            <div class="booking-card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="booking-image">
                            <img src="{{ $booking->villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $booking->villa->title }}">
                            <div class="booking-status status-{{ strtolower($booking->status) }}">
                                @switch($booking->status)
                                    @case('pending')
                                        <i class="fas fa-clock me-1"></i>Onay Bekliyor
                                        @break
                                    @case('confirmed')
                                        <i class="fas fa-check me-1"></i>Onaylandı
                                        @break
                                    @case('active')
                                        <i class="fas fa-play me-1"></i>Aktif
                                        @break
                                    @case('completed')
                                        <i class="fas fa-check-circle me-1"></i>Tamamlandı
                                        @break
                                    @case('cancelled')
                                        <i class="fas fa-times me-1"></i>İptal Edildi
                                        @break
                                    @default
                                        {{ ucfirst($booking->status) }}
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="booking-content">
                            <div class="booking-header">
                                <h4>{{ $booking->villa->title }}</h4>
                                <div class="booking-id">
                                    <small class="text-muted">#{{ $booking->id }}</small>
                                </div>
                            </div>
                            <div class="booking-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    {{ $booking->villa->location->name }}
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}
                                    <small class="text-muted ms-2">({{ $booking->nights }} gece)</small>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $booking->guests }} Kişi
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    {{ number_format($booking->total_price, 2) }} ₺
                                </div>
                            </div>
                            <div class="booking-actions">
                                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detaylar
                                </a>
                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancelBooking({{ $booking->id }})">
                                    <i class="fas fa-times me-1"></i>İptal Et
                                </button>
                                @endif
                                @if($booking->status === 'completed' && !$booking->hasReview())
                                <a href="{{ route('customer.reviews.create', $booking->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-star me-1"></i>Değerlendir
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper mt-5">
        @if($activeBookings->count() > 0)
            {{ $activeBookings->links() }}
        @endif
        @if($pastBookings->count() > 0)
            {{ $pastBookings->links() }}
        @endif
        @if($cancelledBookings->count() > 0)
            {{ $cancelledBookings->links() }}
        @endif
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-calendar-times"></i>
        </div>
        <h3>Henüz rezervasyonunuz yok</h3>
        <p>İlk villa rezervasyonunuzu yapmak için aşağıdaki butona tıklayın.</p>
        <a href="{{ route('villas.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-search me-2"></i>Villa Ara
        </a>
    </div>
    @endif
</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rezervasyonu İptal Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bu rezervasyonu iptal etmek istediğinizden emin misiniz?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    İptal edilen rezervasyonlar geri alınamaz. İptal koşulları için lütfen sözleşmenizi kontrol edin.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                <form id="cancelForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">İptal Et</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bookings-container {
    padding: 2rem 0;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1.5rem;
    padding: 3rem;
    color: white;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

/* Filters */
.filters-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.form-select,
.form-control {
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-select:focus,
.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Booking Items */
.bookings-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.booking-item {
    transition: all 0.3s ease;
}

.booking-card {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.booking-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.booking-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.booking-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.booking-status {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    backdrop-filter: blur(10px);
}

.status-pending {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.status-confirmed {
    background: rgba(34, 197, 94, 0.9);
    color: white;
}

.status-active {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.status-completed {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.status-cancelled {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.booking-content {
    padding: 2rem;
}

.booking-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.booking-header h4 {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.booking-id {
    text-align: right;
}

.booking-details {
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    color: #4b5563;
}

.booking-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.price-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
}

.booking-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 2.5rem;
}

.empty-state h3 {
    color: #1f2937;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

/* Modal Styling */
.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid #e5e7eb;
    padding: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-header {
        padding: 2rem;
    }
    
    .booking-content {
        padding: 1.5rem;
    }
    
    .booking-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .booking-actions {
        justify-content: center;
    }
    
    .filters-section .row {
        gap: 1rem;
    }
}

@media (max-width: 576px) {
    .bookings-container {
        padding: 1rem 0;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .booking-image {
        height: 200px;
    }
    
    .booking-content {
        padding: 1rem;
    }
    
    .booking-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
function cancelBooking(bookingId) {
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    const form = document.getElementById('cancelForm');
    form.action = `/customer/bookings/${bookingId}/cancel`;
    modal.show();
}

function clearFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';
    document.getElementById('searchFilter').value = '';
    filterBookings();
}

function filterBookings() {
    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    const dateFilter = document.getElementById('dateFilter').value;
    const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
    
    const bookingItems = document.querySelectorAll('.booking-item');
    
    bookingItems.forEach(item => {
        const status = item.dataset.status;
        const villaName = item.querySelector('h4').textContent.toLowerCase();
        const checkInDate = item.querySelector('.detail-item:nth-child(2)').textContent;
        
        let showItem = true;
        
        // Status filter
        if (statusFilter && status !== statusFilter) {
            showItem = false;
        }
        
        // Date filter
        if (dateFilter && !checkInDate.includes(dateFilter)) {
            showItem = false;
        }
        
        // Search filter
        if (searchFilter && !villaName.includes(searchFilter)) {
            showItem = false;
        }
        
        item.style.display = showItem ? 'block' : 'none';
    });
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('statusFilter').addEventListener('change', filterBookings);
    document.getElementById('dateFilter').addEventListener('change', filterBookings);
    document.getElementById('searchFilter').addEventListener('input', filterBookings);
});
</script>
@endpush 