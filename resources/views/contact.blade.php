@extends('layouts.app')

@section('title', 'İletişim - VillaLand')
@section('meta_description', 'VillaLand ile iletişime geçin. Villa kiralama ve rezervasyon işlemleriniz için 7/24 hizmetinizdeyiz.')

@section('content')
<!-- Hero Section -->
<section class="contact-hero position-relative overflow-hidden">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-gradient-gold px-4 py-2 rounded-pill">
                            <i class="fas fa-headset me-2"></i>7/24 Destek
                        </span>
                    </div>
                    <h1 class="display-3 fw-bold mb-4">
                        <span class="d-block">Bizimle</span>
                        <span class="text-gradient d-block">İletişime Geçin</span>
                    </h1>
                    <p class="lead mb-5 opacity-90 max-width-600 mx-auto">
                        Villa kiralama, rezervasyon ve tüm sorularınız için profesyonel ekibimiz 
                        size yardımcı olmaya hazır.
                    </p>
                    <div class="hero-stats row g-4 justify-content-center">
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Destek</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center">
                                <div class="stat-number">< 1 Saat</div>
                                <div class="stat-label">Yanıt Süresi</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center">
                                <div class="stat-number">15+</div>
                                <div class="stat-label">Dil Desteği</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center">
                                <div class="stat-number">99%</div>
                                <div class="stat-label">Memnuniyet</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-6">
    <div class="container">
        <div class="row g-5 align-items-start">
            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="contact-info-card">
                    <div class="contact-header mb-5">
                        <h2 class="h3 fw-bold mb-3">İletişim Bilgileri</h2>
                        <p class="text-muted">Size en uygun iletişim kanalını seçin ve bize ulaşın.</p>
                    </div>

                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="method-content">
                                <h5>Adres</h5>
                                <p>Barbaros Bulvarı No:12<br>34349 Beşiktaş/İstanbul</p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="method-content">
                                <h5>Telefon</h5>
                                <p>+90 (212) 555 66 77</p>
                                <small class="text-muted">7/24 Destek Hattı</small>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="method-content">
                                <h5>E-posta</h5>
                                <p>info@villaland.com</p>
                                <small class="text-muted">1 saat içinde yanıt</small>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="method-content">
                                <h5>Çalışma Saatleri</h5>
                                <p>Pazartesi - Pazar: 24 Saat</p>
                                <small class="text-muted">Kesintisiz hizmet</small>
                            </div>
                        </div>
                    </div>

                    <div class="social-section mt-5">
                        <h5 class="mb-3">Sosyal Medya</h5>
                        <div class="social-links">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form-card">
                    <div class="form-header mb-5">
                        <h2 class="h3 fw-bold mb-3">Mesaj Gönderin</h2>
                        <p class="text-muted">Formu doldurun, size en kısa sürede dönüş yapalım.</p>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success alert-modern" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Başarılı!</strong> {{ session('success') }}
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-modern" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Hata!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Ad Soyad</label>
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" name="name" placeholder="Adınız Soyadınız" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">E-posta</label>
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" name="email" placeholder="E-posta adresiniz" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Telefon</label>
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="tel" class="form-control" name="phone" placeholder="Telefon numaranız">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Konu</label>
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <select class="form-control" name="subject" required>
                                            <option value="">Konu seçiniz</option>
                                            <option value="villa-kiralama">Villa Kiralama</option>
                                            <option value="rezervasyon">Rezervasyon</option>
                                            <option value="iptal-degisiklik">İptal/Değişiklik</option>
                                            <option value="sikayet">Şikayet</option>
                                            <option value="oneri">Öneri</option>
                                            <option value="diger">Diğer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Mesaj</label>
                                    <textarea class="form-control" name="message" rows="6" placeholder="Mesajınızı buraya yazın..." required></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-modern w-100">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Mesajı Gönder
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-6 bg-gradient-light">
    <div class="container">
        <div class="text-center mb-6">
            <div class="section-badge mb-4">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-question-circle me-2"></i>Sık Sorulan Sorular
                </span>
            </div>
            <h2 class="display-5 fw-bold mb-4">
                Merak Ettikleriniz
            </h2>
            <p class="lead text-muted max-width-600 mx-auto">
                En sık sorulan sorulara hızlı yanıtlar bulun
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-modern" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Villa rezervasyonu nasıl yapılır?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Villa rezervasyonu yapmak için istediğiniz villayı seçin, tarih ve misafir sayısını belirleyin. Rezervasyon formunu doldurup ödeme işlemini tamamlayın.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                İptal politikası nedir?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                İptal politikamız villa türüne göre değişiklik gösterir. Genellikle 7 gün öncesine kadar ücretsiz iptal imkanı sunuyoruz.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Ödeme seçenekleri nelerdir?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kredi kartı, banka kartı, havale/EFT ve taksitli ödeme seçenekleri mevcuttur. Güvenli ödeme altyapımızla işlemlerinizi güvenle gerçekleştirebilirsiniz.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Check-in ve check-out saatleri nedir?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Standart check-in saati 15:00, check-out saati ise 11:00'dir. Özel durumlar için lütfen bizimle iletişime geçin.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-6">
    <div class="container">
        <div class="text-center mb-6">
            <div class="section-badge mb-4">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-star me-2"></i>Misafir Yorumları
                </span>
            </div>
            <h2 class="display-5 fw-bold mb-4">
                Misafirlerimiz <span class="text-gradient">Ne Diyor?</span>
            </h2>
            <p class="lead text-muted max-width-600 mx-auto">
                Deneyimlerini paylaşan misafirlerimizin görüşleri
            </p>
        </div>

        <div class="row g-4">
            @foreach($latestReviews as $review)
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <img src="{{ $review->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=667eea&color=fff' }}" 
                                 alt="{{ $review->user->name }}">
                        </div>
                        <div class="testimonial-info">
                            <h5>{{ $review->user->name }}</h5>
                            <p>{{ $review->user->city ?? 'Misafir' }}</p>
                        </div>
                    </div>

                    <div class="testimonial-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>

                    <div class="testimonial-content">
                        <p>"{{ $review->comment }}"</p>
                    </div>
                    
                    <div class="testimonial-date">
                        {{ $review->created_at->format('d F Y') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section */
.contact-hero {
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
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.hero-stats .stat-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fbbf24;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

/* Contact Info Card */
.contact-info-card {
    background: white;
    border-radius: 2rem;
    padding: 3rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    height: 100%;
}

.contact-method {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(102, 126, 234, 0.02);
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.contact-method:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.1);
}

.method-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.5rem;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.method-content h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.method-content p {
    color: #4b5563;
    margin-bottom: 0.25rem;
    line-height: 1.5;
}

.method-content small {
    color: #9ca3af;
}

/* Social Links */
.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}

/* Contact Form Card */
.contact-form-card {
    background: white;
    border-radius: 2rem;
    padding: 3rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Form Styling */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    display: block;
}

.input-group {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    z-index: 3;
    font-size: 1rem;
}

.form-control {
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.form-control::placeholder {
    color: #9ca3af;
}

/* Button Styling */
.btn-modern {
    padding: 1rem 2rem;
    border-radius: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

/* Alert Styling */
.alert-modern {
    border: none;
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.alert-icon {
    margin-right: 1rem;
    font-size: 1.25rem;
}

.alert-content {
    flex: 1;
}

/* Background Gradients */
.bg-gradient-light {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

/* FAQ Accordion */
.accordion-modern .accordion-item {
    border: none;
    margin-bottom: 1rem;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.accordion-modern .accordion-button {
    background: white;
    border: none;
    padding: 1.5rem 2rem;
    font-weight: 600;
    color: #1f2937;
    border-radius: 1rem;
}

.accordion-modern .accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.accordion-modern .accordion-button:focus {
    box-shadow: none;
}

.accordion-modern .accordion-body {
    padding: 1.5rem 2rem;
    background: #f8fafc;
    color: #4b5563;
    line-height: 1.6;
}

/* Testimonial Cards */
.testimonial-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.testimonial-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
}

.testimonial-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 1rem;
}

.testimonial-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testimonial-info h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.testimonial-info p {
    color: #6b7280;
    font-size: 0.9rem;
    margin: 0;
}

.testimonial-rating {
    margin-bottom: 1.5rem;
    color: #fbbf24;
}

.testimonial-content p {
    color: #4b5563;
    line-height: 1.6;
    font-style: italic;
    margin-bottom: 1.5rem;
}

.testimonial-date {
    color: #9ca3af;
    font-size: 0.875rem;
    text-align: right;
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
@media (max-width: 768px) {
    .contact-hero h1 {
        font-size: 2.5rem !important;
    }
    
    .contact-info-card,
    .contact-form-card {
        padding: 2rem;
    }
    
    .py-6 {
        padding: 3rem 0;
    }
    
    .hero-stats .col-6 {
        margin-bottom: 1rem;
    }
    
    .method-icon {
        width: 50px;
        height: 50px;
        font-size: 1rem;
    }
    
    .social-link {
        width: 45px;
        height: 45px;
    }
}

@media (max-width: 576px) {
    .contact-hero h1 {
        font-size: 2rem !important;
    }
    
    .contact-info-card,
    .contact-form-card {
        padding: 1.5rem;
    }
}
</style>
@endpush