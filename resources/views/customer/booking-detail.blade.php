@extends('layouts.customer')

@section('title', 'Rezervasyon Detayı - VillaLand')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Rezervasyon Detayı</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.bookings') }}">Rezervasyonlar</a></li>
                <li class="breadcrumb-item active">Rezervasyon #{{ $booking->id }}</li>
            </ol>
        </div>
        <div>
            @if(in_array($booking->status, ['pending', 'confirmed']))
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                <i class="fas fa-times mr-2"></i>Rezervasyonu İptal Et
            </button>
            @endif
            <a href="{{ route('customer.bookings') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-arrow-left mr-2"></i>Geri Dön
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Booking Details -->
        <div class="col-lg-8">
            <!-- Booking Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rezervasyon Durumu</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4>Rezervasyon #{{ $booking->id }}</h4>
                            <p class="text-muted mb-0">{{ $booking->created_at->format('d.m.Y H:i') }} tarihinde oluşturuldu</p>
                        </div>
                        <div class="col-md-6 text-md-right">
                            @switch($booking->status)
                                @case('pending')
                                    <span class="badge badge-warning badge-lg">
                                        <i class="fas fa-clock mr-1"></i>Onay Bekliyor
                                    </span>
                                    @break
                                @case('confirmed')
                                    <span class="badge badge-success badge-lg">
                                        <i class="fas fa-check mr-1"></i>Onaylandı
                                    </span>
                                    @break
                                @case('active')
                                    <span class="badge badge-info badge-lg">
                                        <i class="fas fa-play mr-1"></i>Aktif
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="badge badge-success badge-lg">
                                        <i class="fas fa-check-circle mr-1"></i>Tamamlandı
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="badge badge-danger badge-lg">
                                        <i class="fas fa-times mr-1"></i>İptal Edildi
                                    </span>
                                    @break
                                @default
                                    <span class="badge badge-secondary badge-lg">{{ ucfirst($booking->status) }}</span>
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villa Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Villa Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $booking->villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $booking->villa->title }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $booking->villa->title }}</h4>
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $booking->villa->address }}
                            </p>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="feature-item mb-2">
                                        <i class="fas fa-bed text-primary mr-2"></i>
                                        <strong>{{ $booking->villa->bedrooms ?? 'N/A' }}</strong> Yatak Odası
                                    </div>
                                    <div class="feature-item mb-2">
                                        <i class="fas fa-bath text-primary mr-2"></i>
                                        <strong>{{ $booking->villa->bathrooms ?? 'N/A' }}</strong> Banyo
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="feature-item mb-2">
                                        <i class="fas fa-users text-primary mr-2"></i>
                                        <strong>{{ $booking->villa->capacity ?? 'N/A' }}</strong> Kişi Kapasitesi
                                    </div>
                                    <div class="feature-item mb-2">
                                        <i class="fas fa-home text-primary mr-2"></i>
                                        <strong>{{ $booking->villa->size ?? 'N/A' }}</strong> m² Alan
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('villas.show', $booking->villa->slug) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye mr-1"></i>Villa Detayını Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rezervasyon Detayları</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Giriş Tarihi:</td>
                                    <td>{{ $booking->check_in->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Çıkış Tarihi:</td>
                                    <td>{{ $booking->check_out->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gece Sayısı:</td>
                                    <td>{{ $booking->check_in->diffInDays($booking->check_out) }} Gece</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Misafir Sayısı:</td>
                                    <td>{{ $booking->guests ?? 'N/A' }} Kişi</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Rezervasyon Tarihi:</td>
                                    <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Son Güncelleme:</td>
                                    <td>{{ $booking->updated_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                @if($booking->special_requests)
                                <tr>
                                    <td class="font-weight-bold">Özel İstekler:</td>
                                    <td>{{ $booking->special_requests }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Payment Summary -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ödeme Özeti</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Gecelik Ücret:</td>
                            <td class="text-right">₺{{ number_format($booking->villa->price_per_night ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Gece Sayısı:</td>
                            <td class="text-right">{{ $booking->check_in->diffInDays($booking->check_out) }}</td>
                        </tr>
                        <tr>
                            <td>Ara Toplam:</td>
                            <td class="text-right">₺{{ number_format(($booking->villa->price_per_night ?? 0) * $booking->check_in->diffInDays($booking->check_out), 0, ',', '.') }}</td>
                        </tr>
                        @if($booking->cleaning_fee ?? 0 > 0)
                        <tr>
                            <td>Temizlik Ücreti:</td>
                            <td class="text-right">₺{{ number_format($booking->cleaning_fee, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        @if($booking->service_fee ?? 0 > 0)
                        <tr>
                            <td>Hizmet Bedeli:</td>
                            <td class="text-right">₺{{ number_format($booking->service_fee, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="border-top">
                            <td class="font-weight-bold">Toplam Tutar:</td>
                            <td class="text-right font-weight-bold text-primary h5">₺{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    
                    @if($booking->status === 'completed')
                    <div class="mt-3">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            Ödeme Tamamlandı
                        </div>
                    </div>
                    @elseif($booking->status === 'confirmed')
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Rezervasyon Onaylandı
                        </div>
                    </div>
                    @else
                    <div class="mt-3">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Onay Bekleniyor
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">İletişim</h6>
                </div>
                <div class="card-body">
                    <p class="mb-3">Rezervasyonunuzla ilgili sorularınız için:</p>
                    
                    <div class="contact-item mb-3">
                        <i class="fas fa-phone text-primary mr-2"></i>
                        <strong>Telefon:</strong><br>
                        <a href="tel:+905551234567">+90 555 123 45 67</a>
                    </div>
                    
                    <div class="contact-item mb-3">
                        <i class="fas fa-envelope text-primary mr-2"></i>
                        <strong>E-posta:</strong><br>
                        <a href="mailto:info@villaland.com">info@villaland.com</a>
                    </div>
                    
                    <div class="contact-item mb-3">
                        <i class="fas fa-clock text-primary mr-2"></i>
                        <strong>Çalışma Saatleri:</strong><br>
                        7/24 Hizmet
                    </div>
                    
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-headset mr-2"></i>İletişime Geç
                    </a>
                </div>
            </div>
        </div>
    </div>
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
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    İptal edilen rezervasyonlar geri alınamaz. İptal koşulları için lütfen sözleşmenizi kontrol edin.
                </div>
                <div class="booking-summary">
                    <h6>Rezervasyon Özeti:</h6>
                    <ul>
                        <li><strong>Villa:</strong> {{ $booking->villa->title }}</li>
                        <li><strong>Tarih:</strong> {{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}</li>
                        <li><strong>Tutar:</strong> ₺{{ number_format($booking->total_price, 0, ',', '.') }}</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" class="d-inline">
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
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
}

.contact-item {
    padding: 0.5rem 0;
}

.booking-summary ul {
    margin-bottom: 0;
    padding-left: 1.5rem;
}

.table-borderless td {
    border: none;
    padding: 0.5rem 0;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

.alert {
    border-radius: 0.5rem;
}

.modal-content {
    border-radius: 0.75rem;
}
</style>
@endpush 