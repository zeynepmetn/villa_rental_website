@extends('layouts.app')

@section('title', 'Hakkımızda - VillaLand')
@section('meta_description', 'VillaLand olarak 2010 yılından bu yana Türkiye\'nin en güzel tatil bölgelerinde lüks villa kiralama hizmeti sunuyoruz.')

@section('content')
<!-- Hero Section -->
<section class="about-hero position-relative overflow-hidden">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content text-white">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-gradient-gold px-4 py-2 rounded-pill">
                            <i class="fas fa-award me-2"></i>2010'dan Bu Yana
                        </span>
                    </div>
                    <h1 class="display-3 fw-bold mb-4">
                        <span class="d-block">Türkiye'nin</span>
                        <span class="text-gradient d-block">Lider Villa</span>
                        <span class="d-block">Kiralama Platformu</span>
                    </h1>
                    <p class="lead mb-5 opacity-90">
                        13 yıllık deneyimimizle, misafirlerimize sadece bir tatil değil, 
                        unutulmaz yaşam deneyimleri sunuyoruz.
                    </p>
                    <div class="hero-stats row g-4">
                        <div class="col-4">
                            <div class="stat-item text-center">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Lüks Villa</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item text-center">
                                <div class="stat-number">10K+</div>
                                <div class="stat-label">Mutlu Misafir</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item text-center">
                                <div class="stat-number">4.9</div>
                                <div class="stat-label">Ortalama Puan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-images-container">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-image-card main-image">
                                <img src="{{ url('images/about/about-1.jpg') }}" alt="Lüks Villa" class="img-fluid rounded-3">
                                <div class="image-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-home fa-2x mb-2"></i>
                                        <h6>Lüks Villalar</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="hero-image-card secondary-image">
                                        <img src="{{ url('images/about/about-2.jpg') }}" alt="Villa İç Mekan" class="img-fluid rounded-3">
                                        <div class="image-overlay">
                                            <div class="overlay-content">
                                                <i class="fas fa-couch fa-lg mb-2"></i>
                                                <small>Konforlu İç Mekan</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="hero-image-card secondary-image">
                                        <img src="{{ url('images/about/about-3.jpg') }}" alt="Villa Havuz" class="img-fluid rounded-3">
                                        <div class="image-overlay">
                                            <div class="overlay-content">
                                                <i class="fas fa-swimming-pool fa-lg mb-2"></i>
                                                <small>Özel Havuz</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-6">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="content-block">
                    <div class="section-badge mb-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-bullseye me-2"></i>Misyonumuz
                        </span>
                    </div>
                    <h2 class="display-5 fw-bold mb-4">
                        Tatil Deneyimlerini <span class="text-gradient">Yeniden Tanımlıyoruz</span>
                    </h2>
                    <p class="lead text-muted mb-4">
                        VillaLand olarak, sadece konaklama değil, yaşam tarzı sunuyoruz. 
                        Her villamız özenle seçilmiş, her detay misafir memnuniyeti için düşünülmüş.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon me-3">
                                <i class="fas fa-check-circle" style="color: #ffffff; font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Özenle Seçilmiş Villalar</h6>
                                <p class="text-muted mb-0 small">Her villa kalite, konfor ve güvenlik açısından titizlikle değerlendirilir.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon me-3">
                                <i class="fas fa-check-circle" style="color: #ffffff; font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">7/24 Profesyonel Destek</h6>
                                <p class="text-muted mb-0 small">Tatil öncesi, sırası ve sonrasında her zaman yanınızdayız.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex align-items-start">
                            <div class="feature-icon me-3">
                                <i class="fas fa-check-circle" style="color: #ffffff; font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Güvenli Rezervasyon</h6>
                                <p class="text-muted mb-0 small">SSL korumalı ödeme sistemi ile güvenli rezervasyon deneyimi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">13+</div>
                            <div class="stat-label">Yıllık Deneyim</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Premium Villa</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Mutlu Misafir</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">Destinasyon</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-6 bg-gradient-light">
    <div class="container">
        <div class="text-center mb-6">
            <div class="section-badge mb-4">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-heart me-2"></i>Değerlerimiz
                </span>
            </div>
            <h2 class="display-5 fw-bold mb-4">
                Neden <span class="text-gradient">VillaLand</span>?
            </h2>
            <p class="lead text-muted max-width-600 mx-auto">
                Misafirlerimize en iyi deneyimi sunmak için benimsediğimiz temel değerler
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="value-card h-100">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="value-title">Müşteri Odaklılık</h4>
                    <p class="value-description">
                        Misafirlerimizin memnuniyeti bizim için her şeyden önemli. 
                        Her detayı düşünüyor, her ihtiyaca çözüm sunuyoruz.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="value-card h-100">
                    <div class="value-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h4 class="value-title">Kalite Standartları</h4>
                    <p class="value-description">
                        Villalarımızı en yüksek kalite standartlarında tutuyor, 
                        düzenli denetimler ve bakımlarla bu standardı koruyoruz.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="value-card h-100">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="value-title">Güvenilirlik</h4>
                    <p class="value-description">
                        Şeffaf ve dürüst iş anlayışımızla, misafirlerimizin güvenini 
                        kazanıyor ve bunu korumak için çalışıyoruz.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="value-card h-100">
                    <div class="value-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4 class="value-title">7/24 Hizmet</h4>
                    <p class="value-description">
                        Profesyonel ekibimiz tatil öncesi, sırası ve sonrasında 
                        her zaman yanınızda, sorunsuz bir deneyim için.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="value-card h-100">
                    <div class="value-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4 class="value-title">Mükemmellik</h4>
                    <p class="value-description">
                        Her projede mükemmelliği hedefliyor, sürekli gelişim 
                        ve yenilik anlayışıyla hizmet kalitemizi artırıyoruz.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="value-card h-100">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="value-title">Güven</h4>
                    <p class="value-description">
                        Uzun vadeli ilişkiler kurarak, misafirlerimizin 
                        güvenini kazanmak ve sürdürmek en büyük önceliğimiz.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-6">
    <div class="container">
        <div class="text-center mb-6">
            <div class="section-badge mb-4">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-users me-2"></i>Ekibimiz
                </span>
            </div>
            <h2 class="display-5 fw-bold mb-4">
                Deneyimli <span class="text-gradient">Profesyonel Ekip</span>
            </h2>
            <p class="lead text-muted max-width-600 mx-auto">
                Alanında uzman, deneyimli ve misafir memnuniyetine odaklı ekibimizle hizmetinizdeyiz
            </p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://ui-avatars.com/api/?name=Sinem+Yılmaz&background=8b5cf6&color=fff&size=200" alt="Sinem Yılmaz" class="img-fluid">
                    </div>
                    <div class="team-content">
                        <h5 class="team-name">Sinem Yılmaz</h5>
                        <p class="team-position">Rezervasyon Uzmanı</p>
                        <p class="team-description">Müşteri rezervasyon süreçleri ve koordinasyon</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://ui-avatars.com/api/?name=Zeynep+Metin&background=ec4899&color=fff&size=200" alt="Zeynep Metin" class="img-fluid">
                    </div>
                    <div class="team-content">
                        <h5 class="team-name">Zeynep Metin</h5>
                        <p class="team-position">Villa Koordinatörü</p>
                        <p class="team-description">Villa bakım ve temizlik süreçleri yönetimi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team-card">
                    <div class="team-image">
                        <img src="https://ui-avatars.com/api/?name=Sena+Matur&background=06b6d4&color=fff&size=200" alt="Sena Matur" class="img-fluid">
                    </div>
                    <div class="team-content">
                        <h5 class="team-name">Sena Matur</h5>
                        <p class="team-position">Misafir İlişkileri Uzmanı</p>
                        <p class="team-description">Misafir deneyimi ve özel hizmetler koordinasyonu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-6 bg-gradient-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3">
                    Hayalinizdeki Tatili Planlayın
                </h2>
                <p class="lead mb-0 opacity-90">
                    500+ lüks villa arasından size en uygun olanını seçin ve unutulmaz bir tatil deneyimi yaşayın.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('villas.index') }}" class="btn btn-light btn-lg px-5 py-3">
                    <i class="fas fa-search me-2"></i>Villaları Keşfet
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section */
.about-hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    z-index: 1;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 2;
}

.hero-content {
    z-index: 3;
    position: relative;
    animation: fadeInUp 1s ease-out;
}

.container.position-relative {
    z-index: 3;
}

.bg-gradient-gold {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
}

.text-gradient {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.min-vh-100 {
    min-height: 100vh;
}

.py-6 {
    padding: 5rem 0;
}

.mb-6 {
    margin-bottom: 4rem;
}

.max-width-600 {
    max-width: 600px;
}

/* Hero Stats */
.hero-stats .stat-item {
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    backdrop-filter: blur(10px);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fbbf24;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

/* Hero Images Container */
.hero-images-container {
    padding: 2rem 0;
}

.hero-image-card {
    position: relative;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.hero-image-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(102, 126, 234, 0.2);
}

.main-image {
    height: 320px;
}

.secondary-image {
    height: 150px;
}

.hero-image-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hero-image-card:hover img {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.hero-image-card:hover .image-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.hero-image-card:hover .overlay-content {
    transform: translateY(0);
}

.overlay-content h6 {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
}

.overlay-content small {
    font-size: 0.85rem;
    font-weight: 500;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stat-card .stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-card .stat-label {
    color: #6b7280;
    font-weight: 500;
}

/* Background Gradients */
.bg-gradient-light {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Value Cards */
.value-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(102, 126, 234, 0.05);
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.value-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
}

.value-description {
    color: #6b7280;
    line-height: 1.6;
    margin: 0;
}

/* Team Cards */
.team-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    text-align: center;
    max-width: 280px;
    margin: 0 auto;
}

.team-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.15);
}

.team-image {
    position: relative;
    overflow: hidden;
}

.team-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-card:hover .team-image img {
    transform: scale(1.05);
}

.team-content {
    padding: 1.5rem 1rem;
}

.team-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.team-position {
    color: #667eea;
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.team-description {
    color: #6b7280;
    font-size: 0.85rem;
    line-height: 1.4;
    margin: 0;
}

/* Feature List */
.feature-item {
    padding: 1rem;
    background: rgba(102, 126, 234, 0.02);
    border-radius: 0.75rem;
    border-left: 4px solid #667eea;
}

.feature-icon {
    font-size: 1.25rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .main-image {
        height: 280px;
    }
    
    .secondary-image {
        height: 130px;
    }
}

@media (max-width: 768px) {
    .about-hero h1 {
        font-size: 2.5rem !important;
    }
    
    .hero-images-container {
        padding: 1rem 0;
        margin-top: 2rem;
    }
    
    .main-image {
        height: 200px;
    }
    
    .secondary-image {
        height: 95px;
    }
    
    .py-6 {
        padding: 3rem 0;
    }
    
    .hero-stats {
        margin-top: 2rem;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .value-card {
        padding: 2rem 1.5rem;
    }
    
    .overlay-content h6 {
        font-size: 0.9rem;
    }
    
    .overlay-content small {
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .about-hero h1 {
        font-size: 2rem !important;
    }
    
    .hero-stats .col-4 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }
}
</style>
@endpush 