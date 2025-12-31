@extends('layouts.app')

@section('title', 'VillaLand - Lüks Villa Kiralama')
@section('meta_description', 'Türkiye\'nin en güzel tatil beldelerinde özel havuzlu, lüks ve konforlu villa kiralama hizmeti. Unutulmaz bir tatil deneyimi için hemen rezervasyon yapın.')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative d-flex align-items-center overflow-hidden" style="min-height: 100vh;">
    <div class="hero-bg position-absolute w-100 h-100" style="background-image: url('/images/hero.jpg'); background-size: cover; background-position: center;"></div>
    <div class="overlay position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(20,25,47,0.7) 0%, rgba(79,70,229,0.6) 50%, rgba(124,58,237,0.5) 100%);"></div>
    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-lg-8 col-xl-7 ps-lg-5 ps-xl-6 ms-lg-5">
                <div class="hero-content">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-gradient-primary px-4 py-2 rounded-pill fs-6 fw-normal">
                            <i class="fas fa-star me-2"></i>Türkiye'nin #1 Villa Kiralama Platformu
                        </span>
                    </div>
                    <h1 class="hero-title mb-4">
                        <span class="text-white fw-bold d-block" style="font-size: 4.5rem; line-height: 1.1; letter-spacing: -3px;">
                            Hayalinizdeki
                        </span>
                        <span class="hero-gradient-text fw-bold d-block" style="font-size: 4.5rem; line-height: 1.1; letter-spacing: -3px;">
                            Tatil İçin
                        </span>
                        <span class="text-white fw-bold d-block" style="font-size: 4.5rem; line-height: 1.1; letter-spacing: -3px;">
                            Mükemmel Villalar
                        </span>
                    </h1>
                    <p class="hero-subtitle text-white mb-5" style="font-size: 1.4rem; opacity: 0.95; max-width: 600px; line-height: 1.6;">
                        Özel havuzlu, deniz manzaralı lüks villalarla<br>
                        unutulmaz bir tatil deneyimi yaşayın.
                    </p>
                    <div class="hero-buttons d-flex flex-wrap gap-3">
                        <a href="{{ route('villas.index') }}" class="btn btn-hero-primary btn-lg px-5 py-3">
                            <i class="fas fa-search me-2"></i>Villaları Keşfet
                        </a>
                        <a href="#why-choose-us" class="btn btn-hero-secondary btn-lg px-5 py-3">
                            <i class="fas fa-heart me-2"></i>Neden Bizi Seçmelisiniz?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="hero-floating-elements">
        <div class="floating-card floating-card-1">
            <div class="card border-0 shadow-lg" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1);">
                <div class="card-body text-white text-center p-4">
                    <i class="fas fa-home fa-2x mb-3 text-warning"></i>
                    <h6 class="mb-1">500+</h6>
                    <small>Lüks Villa</small>
                </div>
            </div>
        </div>
        <div class="floating-card floating-card-2">
            <div class="card border-0 shadow-lg" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1);">
                <div class="card-body text-white text-center p-4">
                    <i class="fas fa-users fa-2x mb-3 text-success"></i>
                    <h6 class="mb-1">10K+</h6>
                    <small>Mutlu Misafir</small>
                </div>
            </div>
        </div>
        <div class="floating-card floating-card-3">
            <div class="card border-0 shadow-lg" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1);">
                <div class="card-body text-white text-center p-4">
                    <i class="fas fa-star fa-2x mb-3 text-info"></i>
                    <h6 class="mb-1">4.9</h6>
                    <small>Ortalama Puan</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Locations -->
<section id="popular-locations" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="gradient-text mb-3">Popüler Lokasyonlar</h2>
            <p class="text-muted">Türkiye'nin en güzel tatil beldelerindeki seçkin villalarımızı keşfedin</p>
        </div>
        
        <div class="row g-4">
            <!-- Fethiye -->
            <div class="col-md-4">
                <div class="location-card h-100">
                    <div class="position-relative">
                        <div class="ratio ratio-4x3">
                            <img src="/images/locations/fethiye.jpg" alt="Fethiye" class="rounded-4 object-fit-cover">
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                            <h3 class="h4 mb-2">Fethiye</h3>
                            <p class="mb-0">Eşsiz koyları ve muhteşem doğasıyla Akdeniz'in incisi</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bodrum -->
            <div class="col-md-4">
                <div class="location-card h-100">
                    <div class="position-relative">
                        <div class="ratio ratio-4x3">
                            <img src="/images/locations/bodrum.jpg" alt="Bodrum" class="rounded-4 object-fit-cover">
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                            <h3 class="h4 mb-2">Bodrum</h3>
                            <p class="mb-0">Lüks yaşamın ve eğlencenin buluştuğu beyaz cennet</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Çeşme -->
            <div class="col-md-4">
                <div class="location-card h-100">
                    <div class="position-relative">
                        <div class="ratio ratio-4x3">
                            <img src="/images/locations/cesme.jpg" alt="Çeşme" class="rounded-4 object-fit-cover">
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                            <h3 class="h4 mb-2">Çeşme</h3>
                            <p class="mb-0">Berrak denizi ve rüzgarıyla Ege'nin gözdesi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section id="why-choose-us" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="gradient-text mb-3">Neden Bizi Seçmelisiniz?</h2>
            <p class="text-muted">Villa kiralama konusunda 10 yılı aşkın deneyimimizle size en kaliteli hizmeti sunuyoruz.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 mx-auto mb-4">
                        <i class="fas fa-home text-primary"></i>
                    </div>
                    <h3 class="h5 mb-3">En İyi Villalar</h3>
                    <p class="text-muted mb-0">Özenle seçilmiş, konforlu ve lüks villalar ile unutulmaz bir tatil deneyimi yaşayın.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 mx-auto mb-4">
                        <i class="fas fa-tag text-primary"></i>
                    </div>
                    <h3 class="h5 mb-3">En İyi Fiyat Garantisi</h3>
                    <p class="text-muted mb-0">Piyasadaki en uygun fiyatları sunarak bütçenize uygun tatil yapmanızı sağlıyoruz.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 mx-auto mb-4">
                        <i class="fas fa-shield-alt text-primary"></i>
                    </div>
                    <h3 class="h5 mb-3">Güvenli Ödeme</h3>
                    <p class="text-muted mb-0">SSL sertifikalı güvenli ödeme altyapımız ile endişesiz bir şekilde rezervasyon yapın.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 mx-auto mb-4">
                        <i class="fas fa-headset text-primary"></i>
                    </div>
                    <h3 class="h5 mb-3">7/24 Destek</h3>
                    <p class="text-muted mb-0">Profesyonel ekibimiz tatil öncesi, sırası ve sonrasında her zaman yanınızda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us -->
<section class="py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, rgb(99, 102, 241) 0%, rgb(154, 104, 201) 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold mb-4 text-white">Hakkımızda</h2>
                <p class="fs-6 mb-4 text-white" style="opacity: 0.95;">2010 yılından bu yana Türkiye'nin en güzel tatil bölgelerinde lüks villa kiralama hizmeti sunuyoruz. Misafirlerimize sadece bir tatil değil, unutulmaz bir yaşam deneyimi sunmak için çalışıyoruz.</p>
                <p class="fs-6 mb-4 text-white" style="opacity: 0.9;">Her bir villamız, özenle seçilmiş lokasyonlarda, modern mimari ve yerel kültürün harmonisini yansıtacak şekilde tasarlanmıştır. Özel havuzlardan muhteşem deniz manzaralarına, tam donanımlı mutfaklardan konforlu yatak odalarına kadar her detay düşünülmüştür.</p>
                <p class="fs-6 mb-4 text-white" style="opacity: 0.9;">Profesyonel ekibimiz, rezervasyon sürecinizden başlayarak tatilinizin son gününe kadar size özel hizmet sunuyor. Villarımızda düzenli bakım ve temizlik hizmetleri, 7/24 teknik destek ve concierge servisi ile tatilinizi sorunsuz geçirmenizi sağlıyoruz.</p>
                <a href="{{ route('about') }}" class="btn btn-light btn-lg px-4">
                    Daha Fazla Bilgi <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="/images/about/about-1.jpg" alt="Lüks Villa" class="img-fluid rounded-4 shadow-lg mb-3" style="transform: scale(1.02);">
                        <img src="/images/about/about-2.jpg" alt="Villa İç Mekan" class="img-fluid rounded-4 shadow-lg" style="transform: scale(1.02);">
                    </div>
                    <div class="col-6 mt-5">
                        <img src="/images/about/about-3.jpg" alt="Villa Havuz" class="img-fluid rounded-4 shadow-lg mb-3" style="transform: scale(1.02);">
                        <img src="/images/about/about-4.jpg" alt="Villa Manzara" class="img-fluid rounded-4 shadow-lg" style="transform: scale(1.02);">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="gradient-text mb-4">İletişime Geçin</h2>
                <p class="lead text-muted mb-5">Size en uygun villayı bulmak ve rezervasyon sürecinizde yardımcı olmak için buradayız.</p>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-gradient mx-auto mb-4">
                        <i class="fas fa-phone fa-lg"></i>
                    </div>
                    <h3 class="h5 mb-3">Bizi Arayın</h3>
                    <p class="text-muted mb-0">7/24 Hizmetinizdeyiz</p>
                    <p class="text-primary mb-0">+90 (555) 123 4567</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-gradient mx-auto mb-4">
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                    <h3 class="h5 mb-3">E-posta Gönderin</h3>
                    <p class="text-muted mb-0">Sorularınız İçin</p>
                    <p class="text-primary mb-0">info@villaland.com</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="feature-icon bg-primary bg-gradient mx-auto mb-4">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                    <h3 class="h5 mb-3">Ofisimiz</h3>
                    <p class="text-muted mb-0">Fethiye Merkez</p>
                    <p class="text-primary mb-0">Patlangıç, 535. Sk.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section Styles */
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-bg {
    background-size: cover;
    background-position: center;
    filter: brightness(0.8);
}

.hero-content {
    animation: heroFadeIn 1.2s ease-out;
}

.hero-gradient-text {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 30px rgba(251, 191, 36, 0.3);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.btn-hero-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-hero-secondary {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 600;
    border-radius: 50px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.btn-hero-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
    color: white;
}

/* Floating Cards */
.hero-floating-elements {
    position: absolute;
    top: 80px;
    right: 0;
    width: 100%;
    height: calc(100% - 80px);
    pointer-events: none;
}

.floating-card {
    position: absolute;
    animation: float 6s ease-in-out infinite;
}

.floating-card-1 {
    top: 25%;
    right: 15%;
    animation-delay: 0s;
}

.floating-card-2 {
    top: 50%;
    right: 8%;
    animation-delay: 2s;
}

.floating-card-3 {
    top: 75%;
    right: 20%;
    animation-delay: 4s;
}

/* Other Styles */
.location-card {
    transition: all 0.3s ease;
}

.location-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

/* Animations */
@keyframes heroFadeIn {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

/* Responsive */
@media (max-width: 1400px) {
    .floating-card {
        display: none;
    }
}

@media (max-width: 1200px) {
    .hero-title span {
        font-size: 3.8rem !important;
    }
}

/* Mobile hamburger menu button colors */
@media (max-width: 991.98px) {
    /* Hamburger menu button styling - more specific selectors */
    .navbar.navbar-expand-lg .navbar-toggler {
        border-color: #6366f1 !important;
        color: #6366f1 !important;
        background-color: transparent !important;
        padding: 0.5rem !important;
        border-radius: 0.5rem !important;
        border-width: 2px !important;
    }
    
    .navbar.navbar-expand-lg .navbar-toggler:focus {
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
        border-color: #6366f1 !important;
        outline: none !important;
    }
    
    .navbar.navbar-expand-lg .navbar-toggler:hover {
        background-color: rgba(99, 102, 241, 0.1) !important;
        border-color: #4f46e5 !important;
    }
    
    .navbar.navbar-expand-lg .navbar-toggler .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23667eea' stroke-linecap='round' stroke-miterlimit='10' stroke-width='3' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        width: 24px !important;
        height: 24px !important;
    }
    
    .navbar-collapse .btn-outline-primary {
        border-color: #6366f1 !important;
        color: #6366f1 !important;
        background-color: transparent !important;
    }
    
    .navbar-collapse .btn-outline-primary:hover {
        background-color: #6366f1 !important;
        color: white !important;
    }
    
    .navbar-collapse .btn-primary {
        background-color: #6366f1 !important;
        border-color: #6366f1 !important;
        color: white !important;
    }
    
    .navbar-collapse .btn-primary:hover {
        background-color: #4f46e5 !important;
        border-color: #4f46e5 !important;
    }
}

@media (max-width: 991.98px) {
    .hero-section {
        padding-top: 150px !important;
        min-height: calc(100vh - 150px) !important;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding-top: 180px !important;
        min-height: calc(100vh - 180px) !important;
    }
    
    .hero-title span {
        font-size: 2.8rem !important;
        letter-spacing: -2px !important;
    }
    
    .hero-subtitle {
        font-size: 1.2rem !important;
    }
    
    .hero-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .hero-buttons .btn {
        width: 100%;
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .hero-section {
        padding-top: 200px !important;
        min-height: calc(100vh - 200px) !important;
    }
    
    .hero-title span {
        font-size: 2.2rem !important;
    }
    
    .hero-subtitle {
        font-size: 1.1rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for "Neden Bizi Seçmelisiniz?" button
    const whyChooseUsBtn = document.querySelector('a[href="#why-choose-us"]');
    
    if (whyChooseUsBtn) {
        whyChooseUsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetSection = document.getElementById('why-choose-us');
            if (targetSection) {
                const headerHeight = document.querySelector('.navbar')?.offsetHeight || 0;
                const windowHeight = window.innerHeight;
                const sectionHeight = targetSection.offsetHeight;
                
                // Calculate position to center the section in viewport
                const sectionTop = targetSection.offsetTop;
                const centerOffset = (windowHeight - sectionHeight) / 2;
                const scrollPosition = sectionTop - centerOffset - headerHeight;
                
                window.scrollTo({
                    top: Math.max(0, scrollPosition),
                    behavior: 'smooth'
                });
            }
        });
    }
});
</script>
@endpush
