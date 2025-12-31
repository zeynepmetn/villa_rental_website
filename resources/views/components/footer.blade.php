<footer class="footer-modern">
    <!-- Main Footer -->
    <div class="footer-main">
        <div class="container">
            <div class="row g-4">
                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <h4 class="brand-name mb-3">VillaLand</h4>
                        <p class="brand-description">
                            Türkiye'nin en güzel tatil beldelerinde premium villa kiralama deneyimi.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="footer-links">
                        <h6 class="footer-title">Keşfet</h6>
                        <ul class="link-list">
                            <li><a href="{{ route('home') }}">Ana Sayfa</a></li>
                            <li><a href="{{ route('villas.index') }}">Villalar</a></li>
                            <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                            <li><a href="{{ route('contact') }}">İletişim</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Popular Locations -->
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="footer-links">
                        <h6 class="footer-title">Lokasyonlar</h6>
                        <ul class="link-list">
                            @foreach($globalLocations->where('is_popular', true)->take(4) as $location)
                                <li>
                                    <a href="{{ route('villas.index', ['location' => $location->id]) }}">
                                        {{ $location->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-contact">
                        <h6 class="footer-title">İletişim</h6>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <span>+90 (555) 123 4567</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>info@villaland.com</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Fethiye, Muğla</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">
                        &copy; {{ date('Y') }} VillaLand. Tüm hakları saklıdır.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="footer-legal">
                        <a href="#">Gizlilik Politikası</a>
                        <a href="#">Kullanım Koşulları</a>
                        <a href="#">KVKK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-modern {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    color: #ffffff;
    margin-top: auto;
}

.footer-main {
    padding: 4rem 0 2rem;
    position: relative;
}

.footer-main::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
}

.footer-brand .brand-name {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 1rem;
}

.footer-brand .brand-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.social-links {
    display: flex;
    gap: 0.75rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #ffffff;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-link:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    transform: translateY(-2px);
}

.footer-title {
    color: #ffffff;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 1px;
}

.link-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.link-list li {
    margin-bottom: 0.75rem;
}

.link-list a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    position: relative;
}

.link-list a:hover {
    color: #fbbf24;
    padding-left: 8px;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.95rem;
}

.contact-item i {
    width: 18px;
    color: #fbbf24;
    font-size: 1rem;
}

.footer-bottom {
    padding: 1.5rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
}

.copyright {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
    margin: 0;
}

.footer-legal {
    display: flex;
    gap: 1.5rem;
    justify-content: flex-end;
}

.footer-legal a {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-legal a:hover {
    color: #fbbf24;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-main {
        padding: 3rem 0 1.5rem;
    }
    
    .footer-brand {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .footer-legal {
        justify-content: center;
        margin-top: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .copyright {
        text-align: center;
    }
}

@media (max-width: 576px) {
    .footer-legal {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
}
</style>
