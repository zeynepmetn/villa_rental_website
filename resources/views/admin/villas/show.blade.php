@extends('layouts.admin')

@section('title', 'Villa Detayları')

@section('styles')
<style>
    .detail-card {
        margin-bottom: 1.5rem;
    }

    .detail-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        color: #2d3748;
    }

    .btn-secondary {
        background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
    }

    .btn-secondary:hover {
        background: linear-gradient(45deg, #5a6268 0%, #3d4043 100%);
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
    }

    .feature-badge {
        background: #edf2f7;
        color: #4a5568;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        margin: 0.25rem;
        display: inline-block;
    }

    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .gallery-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .primary-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: rgba(40, 167, 69, 0.9);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
    }

    .gradient-text {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Villa Detayları</h1>
        <div>
            <a href="{{ route('admin.villas.edit', $villa->slug) }}" class="btn btn-primary mr-2">
                <i class="fas fa-edit"></i> Düzenle
            </a>
            <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </a>
        </div>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.villas.index') }}">Villa Yönetimi</a></li>
        <li class="breadcrumb-item active">{{ $villa->title }}</li>
    </ol>

    <div class="row">
        <!-- Temel Bilgiler -->
        <div class="col-lg-8">
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Temel Bilgiler</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="detail-label">Villa Adı</div>
                            <div class="detail-value">{{ $villa->title }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-label">Lokasyon</div>
                            <div class="detail-value">{{ $villa->location->name }}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="detail-label">Açıklama</div>
                            <div class="detail-value">{{ $villa->description }}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="detail-label">Adres</div>
                            <div class="detail-value">{{ $villa->address }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-label">Enlem</div>
                            <div class="detail-value">{{ $villa->latitude }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-label">Boylam</div>
                            <div class="detail-value">{{ $villa->longitude }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detay Bilgileri -->
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Detay Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="detail-label">Yatak Odası</div>
                            <div class="detail-value">{{ $villa->bedrooms }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="detail-label">Banyo</div>
                            <div class="detail-value">{{ $villa->bathrooms }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="detail-label">Kapasite</div>
                            <div class="detail-value">{{ $villa->capacity }} Kişi</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="detail-label">Büyüklük</div>
                            <div class="detail-value">{{ $villa->size }} m²</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-label">Giriş Saati</div>
                            <div class="detail-value">{{ $villa->check_in_time->format('H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-label">Çıkış Saati</div>
                            <div class="detail-value">{{ $villa->check_out_time->format('H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Görseller -->
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Görseller</h6>
                </div>
                <div class="card-body">
                    <div class="image-gallery">
                        @foreach($villa->images as $image)
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $image->path) }}" 
                                 alt="Villa görsel" 
                                 class="gallery-image"
                                 onerror="this.src='{{ asset('images/villa-placeholder.jpg') }}'">
                            @if($image->is_primary)
                            <span class="primary-badge">
                                <i class="fas fa-star"></i> Ana Görsel
                            </span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Panel -->
        <div class="col-lg-4">
            <!-- Durum Bilgileri -->
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Durum</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="detail-label">Durum</div>
                        <div class="detail-value">
                            <span class="badge {{ $villa->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $villa->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="detail-label">Öne Çıkan</div>
                        <div class="detail-value">
                            <span class="badge {{ $villa->is_featured ? 'badge-warning' : 'badge-secondary' }}">
                                {{ $villa->is_featured ? 'Evet' : 'Hayır' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fiyatlandırma -->
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Fiyatlandırma</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="detail-label">Gecelik Fiyat</div>
                        <div class="detail-value">{{ number_format($villa->price_per_night, 2) }} ₺</div>
                    </div>
                </div>
            </div>

            <!-- Özellikler -->
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Özellikler</h6>
                </div>
                <div class="card-body">
                    @forelse($villa->features as $feature)
                        <span class="feature-badge">{{ $feature->name }}</span>
                    @empty
                        <p class="text-muted mb-0">Henüz özellik eklenmemiş.</p>
                    @endforelse
                </div>
            </div>

            <!-- Emlakçı Bilgileri -->
            <div class="card shadow detail-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Emlakçı Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="detail-label">Emlakçı</div>
                        <div class="detail-value">{{ $villa->realtor->name }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="detail-label">E-posta</div>
                        <div class="detail-value">{{ $villa->realtor->email }}</div>
                    </div>
                    @if($villa->realtor->phone)
                    <div class="mb-3">
                        <div class="detail-label">Telefon</div>
                        <div class="detail-value">{{ $villa->realtor->phone }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 