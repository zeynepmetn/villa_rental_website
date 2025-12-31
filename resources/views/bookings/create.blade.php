@extends('layouts.app')

@section('title', 'Rezervasyon Yap - ' . $villa->title)
@section('meta_description', $villa->title . ' için rezervasyon yapın. Kolay ve güvenli ödeme seçenekleri ile hemen tatil planınızı yapın.')

@section('content')
<div class="booking-page">
    <div class="container">
        <!-- Page Header -->
        <div class="booking-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('villas.index') }}">Villalar</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('villas.show', $villa->slug) }}">{{ $villa->title }}</a></li>
                            <li class="breadcrumb-item active">Rezervasyon Onayı</li>
                        </ol>
                    </nav>
                    <h1 class="page-title">Rezervasyon Onayı</h1>
                    <p class="page-subtitle">Rezervasyon bilgilerinizi kontrol edin ve onaylayın</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Villa Detayına Dön
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Villa Info Card -->
            <div class="col-lg-4 order-lg-2">
                <div class="villa-info-card">
                    <div class="villa-image">
                        <img src="{{ $villa->primaryImage->url ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                             alt="{{ $villa->title }}">
                    </div>
                    <div class="villa-details">
                        <h4>{{ $villa->title }}</h4>
                        <p class="location">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $villa->location->name ?? 'Lokasyon Bilgisi Yok' }}
                        </p>
                        <div class="villa-features">
                            <span class="feature">
                                <i class="fas fa-bed"></i>{{ $villa->bedrooms ?? 0 }} Yatak
                            </span>
                            <span class="feature">
                                <i class="fas fa-bath"></i>{{ $villa->bathrooms ?? 0 }} Banyo
                            </span>
                            <span class="feature">
                                <i class="fas fa-users"></i>{{ $villa->capacity ?? 0 }} Kişi
                            </span>
                            <span class="feature">
                                <i class="fas fa-home"></i>{{ $villa->size ?? 0 }}m²
                            </span>
                        </div>
                        <div class="price-info">
                            <span class="price">{{ number_format($villa->price_per_night, 0, ',', '.') }} ₺</span>
                            <span class="period">/ gece</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary and Confirmation -->
            <div class="col-lg-8 order-lg-1">
                <div class="booking-summary-section">
                    <div class="summary-card">
                        <div class="summary-header">
                            <div class="header-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="header-info">
                                <h3>Rezervasyon Detayları</h3>
                                <p>Bilgilerinizi kontrol edin ve rezervasyonu onaylayın</p>
                            </div>
                        </div>
                        
                        <div class="summary-content">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <!-- Booking Details Grid -->
                            <div class="booking-details-grid">
                                <div class="detail-item">
                                    <div class="item-icon">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <div class="item-content">
                                        <span class="label">Giriş Tarihi</span>
                                        <span class="value" id="check-in-display">{{ request('check_in') ? \Carbon\Carbon::parse(request('check_in'))->locale('tr')->isoFormat('D MMMM YYYY') : '-' }}</span>
                                    </div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="item-icon">
                                        <i class="fas fa-calendar-minus"></i>
                                    </div>
                                    <div class="item-content">
                                        <span class="label">Çıkış Tarihi</span>
                                        <span class="value" id="check-out-display">{{ request('check_out') ? \Carbon\Carbon::parse(request('check_out'))->locale('tr')->isoFormat('D MMMM YYYY') : '-' }}</span>
                                    </div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="item-icon">
                                        <i class="fas fa-moon"></i>
                                    </div>
                                    <div class="item-content">
                                        <span class="label">Konaklama Süresi</span>
                                        <span class="value" id="nights-display">
                                            @if(request('check_in') && request('check_out'))
                                                {{ \Carbon\Carbon::parse(request('check_in'))->diffInDays(\Carbon\Carbon::parse(request('check_out'))) }} gece
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="item-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="item-content">
                                        <span class="label">Misafir Sayısı</span>
                                        <span class="value" id="guests-display">{{ request('guests', 1) }} misafir</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Requests Form -->
                            <div class="special-requests-section">
                                <h5><i class="fas fa-comment-dots me-2"></i>Özel İstekler (İsteğe Bağlı)</h5>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Varışınızla ilgili özel isteklerinizi buraya yazabilirsiniz...">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="price-breakdown">
                                <div class="price-header">
                                    <h5><i class="fas fa-calculator me-2"></i>Fiyat Detayı</h5>
                                </div>
                                <div class="price-items">
                                    <div class="price-item">
                                        <span class="label">Gecelik Ücret</span>
                                        <span class="value">{{ number_format($villa->price_per_night, 0, ',', '.') }} ₺</span>
                                    </div>
                                    <div class="price-item">
                                        <span class="label">Gece Sayısı</span>
                                        <span class="value" id="price-nights">
                                            @if(request('check_in') && request('check_out'))
                                                x{{ \Carbon\Carbon::parse(request('check_in'))->diffInDays(\Carbon\Carbon::parse(request('check_out'))) }}
                                            @else
                                                x-
                                            @endif
                                        </span>
                                    </div>
                                    <div class="price-total">
                                        <span class="label">Toplam Tutar</span>
                                        <span class="value" id="total-price">
                                            @if(request('check_in') && request('check_out'))
                                                {{ number_format($villa->price_per_night * \Carbon\Carbon::parse(request('check_in'))->diffInDays(\Carbon\Carbon::parse(request('check_out'))), 0, ',', '.') }} ₺
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Info -->
                            <div class="important-info">
                                <h5><i class="fas fa-info-circle me-2"></i>Önemli Bilgiler</h5>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <i class="fas fa-clock text-primary"></i>
                                        <span>Giriş: 15:00 - Çıkış: 11:00</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-calendar-times text-warning"></i>
                                        <span>3 günden fazla kala ücretsiz iptal</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-shield-alt text-success"></i>
                                        <span>Güvenli ödeme sistemi</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-headset text-info"></i>
                                        <span>7/24 müşteri desteği</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>İptal Et
                                </a>
                                <button type="submit" class="btn btn-success btn-lg" form="booking-form">
                                    <i class="fas fa-check-circle me-2"></i>Rezervasyonu Onayla
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden Form for Submission -->
                <form action="{{ route('bookings.store', $villa) }}" method="POST" id="booking-form">
                    @csrf
                    <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                    <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                    <input type="hidden" name="guests" value="{{ request('guests', 1) }}">
                    <input type="hidden" id="form-notes" name="notes">
                    <input type="hidden" name="total_price" value="{{ request('check_in') && request('check_out') ? $villa->price_per_night * \Carbon\Carbon::parse(request('check_in'))->diffInDays(\Carbon\Carbon::parse(request('check_out'))) : 0 }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.booking-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 120px 0 80px;
}

.booking-header {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #718096;
    font-size: 1.1rem;
    margin: 0;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin-bottom: 1rem;
}

.breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
}

/* Villa Info Card */
.villa-info-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: sticky;
    top: 140px;
}

.villa-image {
    height: 250px;
    overflow: hidden;
}

.villa-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.villa-details {
    padding: 1.5rem;
}

.villa-details h4 {
    color: #2d3748;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.villa-details .location {
    color: #718096;
    margin-bottom: 1rem;
}

.villa-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.villa-features .feature {
    background: #f7fafc;
    padding: 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #4a5568;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.villa-features .feature i {
    color: #667eea;
    font-size: 1rem;
}

.price-info {
    text-align: center;
    padding: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 0.75rem;
    margin: -0.5rem;
    margin-top: 0;
}

.price-info .price {
    font-size: 1.75rem;
    font-weight: 700;
}

.price-info .period {
    font-size: 1rem;
    opacity: 0.9;
}

/* Summary Section */
.booking-summary-section {
    width: 100%;
}

.summary-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.summary-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.header-info h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.header-info p {
    margin: 0.5rem 0 0;
    opacity: 0.9;
}

.summary-content {
    padding: 2rem;
}

/* Booking Details Grid */
.booking-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    border-left: 4px solid #667eea;
}

.item-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.item-content {
    display: flex;
    flex-direction: column;
}

.item-content .label {
    font-size: 0.875rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.item-content .value {
    font-size: 1.1rem;
    color: #2d3748;
    font-weight: 600;
}

/* Special Requests */
.special-requests-section {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid #48bb78;
}

.special-requests-section h5 {
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.special-requests-section .form-control {
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.special-requests-section .form-control:focus {
    border-color: #48bb78;
    box-shadow: 0 0 0 0.2rem rgba(72, 187, 120, 0.25);
}

/* Price Breakdown */
.price-breakdown {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid #f6ad55;
}

.price-header h5 {
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.price-items {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.price-item:last-child {
    border-bottom: none;
}

.price-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    margin-top: 1rem;
    border-top: 2px solid #e2e8f0;
    font-size: 1.25rem;
    font-weight: 700;
}

.price-total .value {
    color: #667eea;
    font-size: 1.5rem;
}

/* Important Info */
.important-info {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid #4299e1;
}

.important-info h5 {
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
    color: #4a5568;
}

.info-item i {
    font-size: 1.1rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    padding-top: 1rem;
}

.btn-lg {
    padding: 1rem 2.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    min-width: 200px;
}

.btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    border: none;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
}

.btn-outline-secondary {
    border: 2px solid #e2e8f0;
    color: #4a5568;
    background: white;
}

.btn-outline-secondary:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .booking-page {
        padding: 100px 0 60px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .booking-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .summary-header {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .summary-content {
        padding: 1.5rem;
    }
    
    .villa-info-card {
        position: static;
        margin-bottom: 2rem;
    }
    
    .villa-features {
        grid-template-columns: 1fr;
    }
    
    .booking-details-grid {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-lg {
        width: 100%;
        min-width: auto;
    }
}

@media (max-width: 576px) {
    .booking-page {
        padding: 90px 0 50px;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .booking-header {
        padding: 1rem;
    }
    
    .summary-header {
        padding: 1rem;
    }
    
    .summary-content {
        padding: 1rem;
    }
    
    .villa-details {
        padding: 1rem;
    }
    
    .detail-item {
        padding: 1rem;
    }
    
    .special-requests-section,
    .price-breakdown,
    .important-info {
        padding: 1rem;
    }
}
</style>
@endpush

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notesInput = document.getElementById('notes');
    const bookingForm = document.getElementById('booking-form');
    const formNotes = document.getElementById('form-notes');
    
    // Update notes before form submission
    bookingForm.addEventListener('submit', function(e) {
        console.log('Form submitting...');
        
        // Check if user is logged in
        @guest
            e.preventDefault();
            alert('Rezervasyon yapmak için giriş yapmanız gerekiyor.');
            window.location.href = '{{ route('login') }}';
            return;
        @endguest
        
        // Update notes in hidden form
        if (formNotes && notesInput) {
            formNotes.value = notesInput.value;
        }
        
        console.log('Form data being submitted:', {
            check_in: bookingForm.querySelector('input[name="check_in"]').value,
            check_out: bookingForm.querySelector('input[name="check_out"]').value,
            guests: bookingForm.querySelector('input[name="guests"]').value,
            notes: formNotes ? formNotes.value : '',
            action: bookingForm.action
        });
    });
});
</script>
@endsection
