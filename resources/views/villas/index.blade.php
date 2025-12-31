@extends('layouts.app')

@section('title', 'Villalar')
@section('meta_description', 'VillaLand\'ın benzersiz villa koleksiyonunu keşfedin. Özel havuzlu, deniz manzaralı, lüks ve konforlu villalar ile mükemmel bir tatil sizi bekliyor.')

@section('content')
<!-- Modern Hero Section -->
<div class="villas-hero">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb modern-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item active">Villalar</li>
                        </ol>
                    </nav>
                    <h1 class="hero-title">Premium Villa Koleksiyonu</h1>
                    <p class="hero-subtitle">Türkiye'nin en güzel lokasyonlarında, lüks ve konforlu villalar ile unutulmaz tatil deneyimi yaşayın.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $villas->total() }}</div>
                            <div class="stat-label">Villa</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $locations->count() }}</div>
                            <div class="stat-label">Lokasyon</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="villas-content">
    <div class="container">
        <!-- Results Count Above Everything -->
        <div class="results-count-global mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="results-count mb-0">{{ $villas->total() }} villa bulundu</h6>
                            @if(request()->hasAny(['search', 'location', 'features', 'min_price', 'max_price', 'bedrooms', 'bathrooms', 'max_guests']))
                                <small class="text-muted">Aktif filtreler uygulandı</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filters-wrapper">
                    <div class="filters-sidebar">
                        <div class="card shadow-sm modern-filter-card">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtreler</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('villas.index') }}" method="GET" id="villa-filter-form">
                                    <!-- Search -->
                                    <div class="mb-4">
                                        <label class="form-label">Arama</label>
                                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Villa adı veya ID">
                                    </div>

                                    <!-- Location -->
                                    <div class="mb-4">
                                        <label for="location" class="form-label">Lokasyon</label>
                                        <select class="form-select" name="location" id="location">
                                            <option value="">Tümü</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Features -->
                                    <div class="mb-4">
                                        <label class="form-label">Özellikler</label>
                                        @foreach($features as $feature)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]" 
                                                    value="{{ $feature->id }}" id="feature{{ $feature->id }}"
                                                    {{ in_array($feature->id, request('features', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="feature{{ $feature->id }}">
                                                    {{ $feature->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Price Range -->
                                    <div class="mb-4">
                                        <label class="form-label">Fiyat Aralığı</label>
                                        <div class="d-flex gap-2">
                                            <input type="number" class="form-control" name="min_price" 
                                                value="{{ request('min_price') }}" placeholder="Min">
                                            <input type="number" class="form-control" name="max_price" 
                                                value="{{ request('max_price') }}" placeholder="Max">
                                        </div>
                                    </div>

                                    <!-- Bedrooms -->
                                    <div class="mb-4">
                                        <label class="form-label">Yatak Odası</label>
                                        <select class="form-select" name="bedrooms">
                                            <option value="">Tümü</option>
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                                                    {{ $i }}+
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <!-- Bathrooms -->
                                    <div class="mb-4">
                                        <label class="form-label">Banyo</label>
                                        <select class="form-select" name="bathrooms">
                                            <option value="">Tümü</option>
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>
                                                    {{ $i }}+
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <!-- Guests -->
                                    <div class="mb-4">
                                        <label class="form-label">Misafir Sayısı</label>
                                        <select class="form-select" name="max_guests">
                                            <option value="">Tümü</option>
                                            @for($i = 2; $i <= 20; $i += 2)
                                                <option value="{{ $i }}" {{ request('max_guests') == $i ? 'selected' : '' }}>
                                                    {{ $i }}+
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">Filtrele</button>
                                        <a href="{{ route('villas.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Villas Grid -->
            <div class="col-lg-9">
                <div class="villas-grid-wrapper">
                    @if($villas->count() > 0)
                        <div class="villas-grid">
                            <div class="row g-4">
                                @foreach($villas as $villa)
                                    <div class="col-md-6 col-lg-4">
                                        <x-villa-card :villa="$villa" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="pagination-wrapper">
                            {{ $villas->links() }}
                        </div>
                    @else
                        <div class="no-results">
                            <div class="no-results-content">
                                <div class="no-results-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h5>Sonuç bulunamadı</h5>
                                <p>Seçilen kriterlere uygun villa bulunamadı. Filtrelerinizi değiştirmeyi deneyin.</p>
                                <a href="{{ route('villas.index') }}" class="btn btn-primary">
                                    <i class="fas fa-refresh me-2"></i>Filtreleri Temizle
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Destinations -->
<section class="popular-destinations">
    <div class="container">
        <div class="section-header">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="section-title">Popüler Destinasyonlar</h2>
                    <p class="section-subtitle">Türkiye'nin en popüler tatil beldelerindeki villalarımızı keşfedin</p>
                </div>
            </div>
        </div>
        
        <div class="destinations-grid">
            <div class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($locations->where('is_popular', true)->take(6) as $location)
                    <div class="destination-item">
                        <a href="{{ route('villas.index', ['location' => $location->id]) }}" class="destination-card">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    @if($location->image)
                                        <img src="{{ asset('storage/' . $location->image) }}" class="card-img-top" alt="{{ $location->name }}" style="height: 140px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center" style="height: 140px;">
                                            <h5 class="mb-0 text-center px-2">{{ $location->name }}</h5>
                                        </div>
                                    @endif
                                    <div class="destination-overlay">
                                        <h5 class="destination-name">{{ $location->name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Modern Hero Section */
.villas-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    padding: 120px 0 80px;
    overflow: hidden;
}

.villas-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 1000,0 1000,100 0,80"/></svg>');
    background-size: cover;
    background-position: bottom;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.modern-breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.modern-breadcrumb .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.modern-breadcrumb .breadcrumb-item a:hover {
    color: white;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.9);
}

.modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    justify-content: flex-end;
}

.stat-item {
    text-align: center;
    color: white;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Main Content */
.villas-content {
    background: #f8fafc;
    padding: 60px 0;
    min-height: 70vh;
}

.filters-wrapper {
    position: sticky;
    top: 20px;
    z-index: 100;
}

/* Results Count Global */
.results-count-global .card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.results-count-global .results-count {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.1rem;
}

/* Modern Filter Card */
.modern-filter-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.modern-filter-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1.25rem 1.5rem;
}

.modern-filter-card .card-header h5 {
    color: white;
    font-weight: 600;
    margin: 0;
}

.modern-filter-card .card-body {
    padding: 1.5rem;
}

/* Villas Grid */
.villas-grid-wrapper {
    position: relative;
}

.villas-grid {
    margin-bottom: 3rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    padding: 2rem 0;
}

.pagination-wrapper .pagination {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border-radius: 0.75rem;
    overflow: hidden;
}

/* No Results */
.no-results {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.no-results-content {
    text-align: center;
    max-width: 400px;
}

.no-results-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.no-results-icon i {
    font-size: 2rem;
    color: white;
}

.no-results-content h5 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 1rem;
}

.no-results-content p {
    color: #6b7280;
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* Popular Destinations */
.popular-destinations {
    background: white;
    padding: 80px 0;
}

.section-header {
    margin-bottom: 3rem;
    padding: 2rem 0;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    padding: 1rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1.3;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6b7280;
    margin: 0;
}

.destination-item {
    flex: 0 0 auto;
    width: 180px;
}

.destination-card {
    text-decoration: none;
    display: block;
    transition: transform 0.3s ease;
}

.destination-card:hover {
    transform: translateY(-5px);
}

.destination-card .card {
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.destination-card:hover .card {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.destination-overlay {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 50px;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem;
}

.destination-name {
    color: white;
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    width: 100%;
    line-height: 1.2;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
}

/* Enhanced Form Styling */
.form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Villa Card Enhancements */
.villa-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.villa-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.villa-card img {
    height: 220px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.villa-card:hover img {
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        justify-content: center;
        margin-top: 2rem;
    }
    
    .filters-wrapper {
        position: static;
        margin-bottom: 2rem;
    }
}

@media (max-width: 767.98px) {
    .villas-hero {
        padding: 100px 0 60px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .destination-item {
        width: 150px;
    }
}

@media (max-width: 575.98px) {
    .destination-item {
        width: 140px;
    }
    
    .destinations-grid .gap-3 {
        gap: 0.75rem !important;
    }
    
    .destination-name {
        font-size: 0.8rem;
    }
    
    .destination-overlay {
        padding: 0.5rem;
        height: 45px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date range validation
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const minCheckOutDate = new Date(checkInDate);
            minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);
            
            checkOutInput.min = minCheckOutDate.toISOString().split('T')[0];
            
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = minCheckOutDate.toISOString().split('T')[0];
            }
        });
    }
    
    // Smooth scroll for pagination
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            setTimeout(() => {
                document.querySelector('.villas-content').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        });
    });
});
</script>
@endpush
