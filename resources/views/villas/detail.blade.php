@extends('layouts.app')

@section('title', $villa->title)
@section('meta_description', Str::limit(strip_tags($villa->description), 160))

@push('styles')
<style>
.villa-detail-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 120px 0 60px;
    position: relative;
    overflow: hidden;
    z-index: 1;
    margin-top: 0;
}

.villa-detail-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
    z-index: -1;
}

.villa-detail-hero .hero-content {
    position: relative;
    z-index: 2;
}

.villa-detail-hero .hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.villa-detail-hero .hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.villa-detail-hero .hero-features {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.villa-detail-hero .feature-badge {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.9rem;
    border: 1px solid rgba(255,255,255,0.3);
}

.villa-detail-hero .price-display {
    text-align: center;
    margin-bottom: 1rem;
}

.villa-detail-hero .price-amount {
    font-size: 2.5rem;
    font-weight: 700;
    display: block;
}

.villa-detail-hero .price-period {
    font-size: 1rem;
    opacity: 0.9;
}

.villa-detail-hero .rating-display {
    text-align: center;
    margin-bottom: 1rem;
}

.villa-detail-hero .rating-text {
    margin-left: 0.5rem;
    font-size: 0.9rem;
}

.modern-breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.9rem;
}

.modern-breadcrumb .breadcrumb-item {
    color: rgba(255,255,255,0.8);
}

.modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255,255,255,0.6);
    font-weight: 600;
}

.modern-breadcrumb .breadcrumb-item a {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    transition: all 0.3s ease;
}

.modern-breadcrumb .breadcrumb-item a:hover {
    color: white;
    text-decoration: underline;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: white;
    font-weight: 500;
}

/* Villa Gallery Section */
.villa-gallery-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px 0;
}

.modern-gallery {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)) !important;
    gap: 8px !important;
    border-radius: 15px !important;
    overflow: hidden !important;
    box-shadow: 0 10px 20px rgba(0,0,0,0.06) !important;
    background: white !important;
    padding: 12px !important;
}

.gallery-item {
    position: relative !important;
    border-radius: 10px !important;
    overflow: hidden !important;
    aspect-ratio: 2/1 !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 3px 8px rgba(0,0,0,0.06) !important;
}

.gallery-item:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12) !important;
}

.gallery-item img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
    transition: transform 0.3s ease !important;
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
    image-rendering: -webkit-optimize-contrast !important;
    image-rendering: crisp-edges !important;
    image-rendering: optimize-quality !important;
    -webkit-backface-visibility: hidden !important;
    backface-visibility: hidden !important;
    transform: translateZ(0) !important;
}

.gallery-item:hover img {
    transform: scale(1.02) !important;
}

.gallery-item.main-image {
    grid-column: span 2 !important;
    grid-row: span 1 !important;
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-count {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.gallery-nav {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.gallery-nav button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: #ccc;
    cursor: pointer;
    transition: all 0.3s ease;
}

.gallery-nav button.active {
    background: #667eea;
    transform: scale(1.2);
}

.gallery-nav button:hover {
    background: #667eea;
}

/* Slideshow Gallery Styles - Force Overrides */
.slideshow-gallery {
    background: white !important;
    border-radius: 20px !important;
    overflow: hidden !important;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    position: relative !important;
}

.slideshow-container {
    position: relative !important;
    height: 55vh !important;
    min-height: 400px !important;
    max-height: 600px !important;
    overflow: hidden !important;
    width: 100% !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
}

.slideshow-sidebar {
    height: 55vh !important;
    min-height: 400px !important;
    max-height: 600px !important;
    background: #f8f9fa !important;
    display: flex !important;
    flex-direction: column !important;
    border-left: 1px solid #e9ecef !important;
}

.slide {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: opacity 0.6s ease !important;
    z-index: 1 !important;
}

.slide.active {
    opacity: 1 !important;
    visibility: visible !important;
    z-index: 2 !important;
}

.slide-image {
    width: 100% !important;
    height: 100% !important;
    position: relative !important;
    overflow: hidden !important;
    display: block !important;
}

.slide-image img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
    transition: transform 0.6s ease !important;
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
    image-rendering: -webkit-optimize-contrast !important;
    image-rendering: crisp-edges !important;
    image-rendering: optimize-quality !important;
    -webkit-backface-visibility: hidden !important;
    backface-visibility: hidden !important;
    transform: translateZ(0) !important;
}

.slide.active .slide-image img {
    transform: scale(1.02) !important;
    filter: contrast(1.05) saturate(1.1) brightness(1.02) !important;
}

.slide-overlay {
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    background: linear-gradient(transparent, rgba(0,0,0,0.8)) !important;
    padding: 40px !important;
    transform: translateY(100%) !important;
    transition: transform 0.6s ease !important;
    z-index: 5 !important;
}

.slide.active .slide-overlay {
    transform: translateY(0) !important;
}

.slide-info h3 {
    color: white !important;
    font-size: 2rem !important;
    font-weight: 700 !important;
    margin-bottom: 0.5rem !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5) !important;
}

.slide-info p {
    color: rgba(255,255,255,0.9) !important;
    font-size: 1.1rem !important;
    margin: 0 !important;
}

/* Navigation Buttons - Force Overrides */
.slideshow-nav {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: 100% !important;
    display: flex !important;
    justify-content: space-between !important;
    padding: 0 30px !important;
    pointer-events: none !important;
    z-index: 20 !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.nav-btn {
    background: rgba(255,255,255,0.9) !important;
    border: none !important;
    width: 60px !important;
    height: 60px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    pointer-events: all !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    z-index: 21 !important;
    visibility: visible !important;
    opacity: 1 !important;
    position: relative !important;
}

.nav-btn:hover {
    background: white !important;
    transform: scale(1.1) !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
}

.nav-btn i {
    font-size: 1.2rem !important;
    color: #333 !important;
    display: block !important;
    visibility: visible !important;
}

/* Control Buttons - Force Overrides */
.slideshow-controls {
    position: absolute !important;
    top: 20px !important;
    right: 20px !important;
    display: flex !important;
    gap: 10px !important;
    z-index: 20 !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.control-btn {
    background: rgba(0,0,0,0.7) !important;
    border: none !important;
    width: 45px !important;
    height: 45px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    backdrop-filter: blur(10px) !important;
    z-index: 21 !important;
    visibility: visible !important;
    opacity: 1 !important;
    position: relative !important;
}

.control-btn:hover {
    background: rgba(0,0,0,0.9) !important;
    transform: scale(1.1) !important;
}

.control-btn i {
    color: white !important;
    font-size: 1rem !important;
    display: block !important;
    visibility: visible !important;
}

/* Progress Bar - Force Overrides */
.slideshow-progress {
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 4px !important;
    background: rgba(255,255,255,0.3) !important;
    z-index: 10 !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.progress-bar {
    height: 100% !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    transition: width 0.6s ease !important;
    width: 0% !important;
    display: block !important;
    visibility: visible !important;
}

/* Thumbnails - Force Overrides */
.slideshow-thumbnails {
    flex: 1 !important;
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    grid-template-rows: repeat(2, 1fr) !important;
    gap: 12px !important;
    padding: 20px !important;
    overflow: hidden !important;
    scrollbar-width: thin !important;
    visibility: visible !important;
    opacity: 1 !important;
    max-height: calc(100% - 120px) !important;
}

.slideshow-thumbnails::-webkit-scrollbar {
    width: 6px !important;
}

.slideshow-thumbnails::-webkit-scrollbar-track {
    background: #e9ecef !important;
    border-radius: 3px !important;
}

.slideshow-thumbnails::-webkit-scrollbar-thumb {
    background: #667eea !important;
    border-radius: 3px !important;
}

.thumbnail {
    position: relative !important;
    width: 100% !important;
    height: 100% !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    border: 3px solid transparent !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    min-height: 80px !important;
}

.thumbnail.active {
    border-color: #667eea !important;
    transform: scale(1.05) !important;
}

.thumbnail:hover {
    transform: scale(1.02) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.thumbnail img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    image-rendering: -webkit-optimize-contrast !important;
    image-rendering: crisp-edges !important;
    image-rendering: optimize-quality !important;
    -webkit-backface-visibility: hidden !important;
    backface-visibility: hidden !important;
    transform: translateZ(0) !important;
}

.thumbnail-overlay {
    position: absolute !important;
    bottom: 4px !important;
    right: 4px !important;
    background: rgba(0,0,0,0.8) !important;
    color: white !important;
    padding: 2px 6px !important;
    border-radius: 4px !important;
    font-size: 0.7rem !important;
    font-weight: 600 !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Gallery Info */
.gallery-info {
    padding: 20px !important;
    background: white !important;
    border-bottom: 1px solid #e9ecef !important;
    visibility: visible !important;
    opacity: 1 !important;
    flex-shrink: 0 !important;
}

.gallery-info h4 {
    margin: 0 0 0.5rem 0 !important;
    color: #333 !important;
    font-weight: 600 !important;
    font-size: 1.2rem !important;
}

.gallery-info p {
    margin: 0 0 1rem 0 !important;
    font-size: 0.9rem !important;
    color: #666 !important;
}

.gallery-stats {
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    color: #667eea !important;
    background: rgba(102, 126, 234, 0.1) !important;
    padding: 8px 16px !important;
    border-radius: 20px !important;
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Villa Content Section */
.villa-content-section {
    background: #f8f9fa;
    padding: 40px 0;
}

/* Quick Info Cards */
.quick-info-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem 1rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    text-align: center;
    height: 100%;
}

.quick-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.1);
}

.quick-info-card .icon-wrapper {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.2rem;
    box-shadow: 0 6px 15px rgba(102, 126, 234, 0.25);
}

.quick-info-card h6 {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
    color: #333;
}

.quick-info-card small {
    color: #666;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Content Cards */
.content-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    overflow: hidden;
    border: 1px solid #f0f0f0;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.content-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}

.content-card .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.content-card .card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
}

.content-card .card-header h3 i {
    color: #667eea;
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

.content-card .card-body {
    padding: 1.8rem;
}

/* Description Styling */
.villa-description {
    font-size: 1rem;
    line-height: 1.7;
    color: #555;
    margin: 0;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 0.8rem;
}

.feature-item {
    display: flex;
    align-items: center;
    padding: 0.9rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.feature-item:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.25);
}

.feature-item i {
    font-size: 1.1rem;
    margin-right: 0.75rem;
    color: #667eea;
    transition: color 0.3s ease;
    width: 16px;
    text-align: center;
}

.feature-item:hover i {
    color: white;
}

.feature-item span {
    font-weight: 500;
    font-size: 0.9rem;
}

/* Review Section */
.review-header-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.empty-reviews {
    text-align: center;
    padding: 2rem 1.5rem;
    color: #666;
}

.empty-reviews i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.3;
    color: #667eea;
}

.empty-reviews h5 {
    margin-bottom: 0.8rem;
    color: #333;
    font-weight: 600;
}

/* Similar Villas */
.similar-villa-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.similar-villa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}

.similar-villa-card .card-img-top {
    height: 180px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.similar-villa-card:hover .card-img-top {
    transform: scale(1.03);
}

/* Button Improvements */
.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    padding: 0.6rem 1.5rem;
    border-radius: 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.25);
}

@media (max-width: 768px) {
    .villa-detail-hero {
        padding: 100px 0 40px;
    }
    
    .villa-detail-hero .hero-title {
        font-size: 2rem;
    }
    
    .villa-detail-hero .price-amount {
        font-size: 2rem;
    }
    
    .villa-detail-hero .hero-features {
        justify-content: center;
    }
    
    .quick-info-card {
        padding: 1.2rem 0.8rem;
        margin-bottom: 0.8rem;
    }
    
    .quick-info-card .icon-wrapper {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-bottom: 0.8rem;
    }
    
    .quick-info-card h6 {
        font-size: 1.2rem;
    }
    
    .quick-info-card small {
        font-size: 0.8rem;
    }
    
    .content-card .card-header {
        padding: 1.2rem;
    }
    
    .content-card .card-body {
        padding: 1.5rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .feature-item {
        padding: 0.8rem;
    }
    
    .similar-villa-card .card-img-top {
        height: 160px;
    }
    
    .modern-gallery {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 6px;
        padding: 10px;
    }
    
    .gallery-item.main-image {
        grid-column: span 2;
        grid-row: span 1;
    }
    
    .lightbox-nav {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .lightbox-prev {
        left: 15px;
    }
    
    .lightbox-next {
        right: 15px;
    }
    
    .lightbox-close {
        top: 15px;
        left: 15px;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .lightbox-toolbar {
        top: 15px;
        right: 15px;
        gap: 8px;
    }
    
    .lightbox-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .lightbox-thumbnails {
        bottom: 60px;
        max-width: 90%;
    }
    
    .lightbox-counter {
        bottom: 15px;
        font-size: 0.9rem;
        padding: 6px 15px;
    }
    
    .lightbox-info {
        bottom: 15px;
        right: 15px;
        font-size: 0.8rem;
        padding: 6px 12px;
    }
    
    .zoom-indicator {
        bottom: 15px;
        left: 15px;
        font-size: 0.8rem;
        padding: 6px 12px;
    }
    
    /* Mobile Slideshow Styles */
    .slideshow-container {
        height: 45vh !important;
        min-height: 280px !important;
        max-height: 400px !important;
    }
    
    .slideshow-sidebar {
        height: auto !important;
        min-height: auto !important;
        max-height: none !important;
        border-left: none !important;
        border-top: 1px solid #e9ecef !important;
    }
    
    .slideshow-thumbnails {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 8px !important;
        padding: 15px !important;
        max-height: 200px !important;
        overflow-y: auto !important;
    }
    
    .thumbnail {
        height: 60px !important;
    }
    
    .gallery-info {
        padding: 15px !important;
    }
    
    .gallery-info h4 {
        font-size: 1.1rem !important;
    }
    
    .gallery-info p {
        font-size: 0.8rem !important;
    }
    
    .gallery-stats {
        font-size: 1rem !important;
        padding: 6px 12px !important;
        margin-top: 10px !important;
    }
    
    .slide-overlay {
        padding: 20px !important;
    }
    
    .slide-info h3 {
        font-size: 1.5rem !important;
    }
    
    .slide-info p {
        font-size: 1rem !important;
    }
    
    .slideshow-nav {
        padding: 0 15px !important;
    }
    
    .nav-btn {
        width: 45px !important;
        height: 45px !important;
    }
    
    .nav-btn i {
        font-size: 1rem !important;
    }
    
    .slideshow-controls {
        top: 15px !important;
        right: 15px !important;
        gap: 8px !important;
    }
    
    .control-btn {
        width: 40px !important;
        height: 40px !important;
    }
    
    .control-btn i {
        font-size: 0.9rem !important;
    }
    
    .thumbnail-overlay {
        font-size: 0.6rem !important;
        padding: 1px 4px !important;
    }
}

/* Lightbox Modal Styles */
.lightbox-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.lightbox-modal.active {
    display: flex;
    opacity: 1;
}

.lightbox-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.lightbox-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 20px 80px;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    z-index: 10001;
}

.lightbox-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.lightbox-content {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    max-width: 1200px;
    max-height: 100%;
}

.lightbox-slide-container {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 15px;
    background: #000;
}

.lightbox-slides {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-slide.active {
    opacity: 1;
    z-index: 2;
}

.lightbox-slide img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    object-position: center;
    border-radius: 10px;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    image-rendering: optimize-quality;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transform: translateZ(0);
    filter: contrast(1.05) saturate(1.1);
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 30px;
    pointer-events: none;
    z-index: 10001;
}

.lightbox-nav-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    color: white;
    font-size: 1.3rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    pointer-events: all;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-nav-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.lightbox-info-bar {
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    padding: 15px 25px;
    border-radius: 15px;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
    min-height: 60px;
}

.lightbox-counter {
    font-size: 1.1rem;
    font-weight: 600;
    color: #667eea;
}

.lightbox-title {
    font-size: 1.2rem;
    font-weight: 600;
    text-align: center;
    flex: 1;
    margin: 0 20px;
}

.lightbox-controls {
    display: flex;
    gap: 10px;
}

.lightbox-control-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-control-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

/* Mobile Lightbox Styles */
@media (max-width: 768px) {
    .lightbox-container {
        padding: 40px 15px 60px;
    }
    
    .lightbox-close {
        top: 15px;
        right: 15px;
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
    
    .lightbox-nav {
        padding: 0 20px;
    }
    
    .lightbox-nav-btn {
        width: 50px;
        height: 50px;
        font-size: 1.1rem;
    }
    
    .lightbox-info-bar {
        padding: 12px 20px;
        margin-top: 15px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .lightbox-title {
        margin: 0;
        font-size: 1.1rem;
    }
    
    .lightbox-counter {
        font-size: 1rem;
    }
    
    .lightbox-control-btn {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="villa-detail-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb modern-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-white-50">
                                <i class="fas fa-home me-1"></i>Ana Sayfa
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('villas.index') }}" class="text-white-50">
                                <i class="fas fa-building me-1"></i>Villalar
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-white">{{ $villa->title }}</li>
                    </ol>
                </nav>
                
                <h1 class="hero-title mb-4">{{ $villa->title }}</h1>
                
                <p class="hero-subtitle mb-4">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    {{ $villa->location->name }} - {{ $villa->address }}
                </p>
                
                <div class="hero-features">
                    <span class="feature-badge">
                        <i class="fas fa-bed me-2"></i>{{ $villa->bedrooms }} Yatak Odası
                    </span>
                    <span class="feature-badge">
                        <i class="fas fa-bath me-2"></i>{{ $villa->bathrooms }} Banyo
                    </span>
                    <span class="feature-badge">
                        <i class="fas fa-users me-2"></i>{{ $villa->capacity }} Misafir
                    </span>
                    <span class="feature-badge">
                        <i class="fas fa-vector-square me-2"></i>{{ $villa->size }} m²
                    </span>
                </div>
            </div>
            
            <div class="col-lg-4 text-lg-end">
                <div class="price-display mb-3">
                    <div class="price-amount">{{ number_format($villa->price_per_night, 0, ',', '.') }} ₺</div>
                    <div class="price-period">/ gece</div>
                </div>
                
                @if($villa->review_count > 0)
                    <div class="rating-display">
                        <div class="d-flex align-items-center justify-content-lg-end justify-content-center">
                            {!! $villa->star_rating !!}
                            <span class="rating-text ms-2">
                                {{ number_format($villa->average_rating, 1) }} ({{ $villa->review_count }} değerlendirme)
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Villa Gallery -->
<section class="villa-gallery-section">
    <div class="container">
        <div class="row">
            @if($villa->images->count() > 0)
                <div class="col-12">
                    <!-- Slideshow Gallery -->
                    <div class="slideshow-gallery" id="villaSlideshow" onmouseenter="pauseOnHover()" onmouseleave="resumeOnLeave()">
                        <div class="row g-0">
                            <!-- Main Slideshow - Left Side -->
                            <div class="col-lg-7">
                                <div class="slideshow-container">
                                    @foreach($villa->images as $key => $image)
                                        <div class="slide {{ $key === 0 ? 'active' : '' }}" data-slide="{{ $key }}">
                                            <div class="slide-image">
                                                <img src="{{ $image->url }}" 
                                                     alt="{{ $villa->title }} - Görsel {{ $key + 1 }}"
                                                     loading="{{ $key === 0 ? 'eager' : 'lazy' }}"
                                                     decoding="async"
                                                     fetchpriority="{{ $key === 0 ? 'high' : 'auto' }}">
                                                <div class="slide-overlay">
                                                    <div class="slide-info">
                                                        <h3>{{ $villa->title }}</h3>
                                                        <p>{{ $key + 1 }} / {{ $villa->images->count() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Navigation Arrows -->
                                    <div class="slideshow-nav">
                                        <button class="nav-btn prev-btn" onclick="return prevSlide();">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="nav-btn next-btn" onclick="return nextSlide();">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Controls -->
                                    <div class="slideshow-controls">
                                        <button class="control-btn" onclick="return openLightbox();">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div class="slideshow-progress">
                                        <div class="progress-bar" id="progressBar"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Thumbnails and Info - Right Side -->
                            <div class="col-lg-5">
                                <div class="slideshow-sidebar">
                                    <!-- Gallery Info -->
                                    <div class="gallery-info">
                                        <h4><i class="fas fa-images me-2"></i>Villa Galerisi</h4>
                                        <p class="text-muted">{{ $villa->images->count() }} adet fotoğraf • Otomatik geçiş aktif</p>
                                        <div class="gallery-stats">
                                            <span class="current-slide">1</span> / <span class="total-slides">{{ $villa->images->count() }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Thumbnails -->
                                    <div class="slideshow-thumbnails">
                                        @foreach($villa->images as $key => $image)
                                            <div class="thumbnail {{ $key === 0 ? 'active' : '' }}" onclick="return goToSlide({{ $key }});">
                                                <img src="{{ $image->url }}" 
                                                     alt="Thumbnail {{ $key + 1 }}"
                                                     loading="lazy"
                                                     decoding="async">
                                                <div class="thumbnail-overlay">
                                                    <span>{{ $key + 1 }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="lightbox-modal" id="lightboxModal">
    <div class="lightbox-overlay" onclick="closeLightbox()"></div>
    <div class="lightbox-container">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="lightbox-content">
            <div class="lightbox-slide-container">
                <div class="lightbox-slides" id="lightboxSlides">
                    <!-- Slides will be populated by JavaScript -->
                </div>
                
                <!-- Navigation -->
                <div class="lightbox-nav">
                    <button class="lightbox-nav-btn lightbox-prev" onclick="lightboxPrevSlide()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="lightbox-nav-btn lightbox-next" onclick="lightboxNextSlide()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <!-- Info Bar -->
            <div class="lightbox-info-bar">
                <div class="lightbox-counter">
                    <span class="lightbox-current">1</span> / <span class="lightbox-total">{{ $villa->images->count() }}</span>
                </div>
                <div class="lightbox-title">{{ $villa->title }}</div>
                <div class="lightbox-controls">
                    <button class="lightbox-control-btn" onclick="toggleLightboxSlideshow()">
                        <i class="fas fa-pause" id="lightboxPlayIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="villa-content-section">
    <div class="container">
        <div class="row">
            <!-- Villa Details -->
            <div class="col-lg-8">
                <!-- Quick Info -->
                <div class="row g-4 mb-5">
                    <div class="col-6 col-md-3">
                        <div class="quick-info-card">
                            <div class="icon-wrapper">
                                <i class="fas fa-bed"></i>
                            </div>
                            <h6>{{ $villa->bedrooms }}</h6>
                            <small>Yatak Odası</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quick-info-card">
                            <div class="icon-wrapper">
                                <i class="fas fa-bath"></i>
                            </div>
                            <h6>{{ $villa->bathrooms }}</h6>
                            <small>Banyo</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quick-info-card">
                            <div class="icon-wrapper">
                                <i class="fas fa-users"></i>
                            </div>
                            <h6>{{ $villa->capacity }}</h6>
                            <small>Misafir</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quick-info-card">
                            <div class="icon-wrapper">
                                <i class="fas fa-vector-square"></i>
                            </div>
                            <h6>{{ $villa->size }}</h6>
                            <small>m²</small>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="content-card">
                    <div class="card-header">
                        <h3><i class="fas fa-home"></i>Villa Hakkında</h3>
                    </div>
                    <div class="card-body">
                        <p class="villa-description">{!! nl2br(e($villa->description)) !!}</p>
                    </div>
                </div>
                
                <!-- Features -->
                <div class="content-card">
                    <div class="card-header">
                        <h3><i class="fas fa-star"></i>Özellikler & Olanaklar</h3>
                    </div>
                    <div class="card-body">
                        <div class="features-grid">
                            @foreach($villa->features as $feature)
                                <div class="feature-item">
                                    <i class="fas fa-{{ $feature->icon }}"></i>
                                    <span>{{ $feature->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Reviews -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>
                                <i class="fas fa-star"></i>
                                Misafir Yorumları
                                @if($villa->review_count > 0)
                                    <span class="review-header-badge ms-3">{{ $villa->review_count }}</span>
                                @endif
                            </h3>
                            @if($villa->review_count > 0)
                                <div>
                                    {!! $villa->star_rating !!}
                                    <span class="ms-2">{{ number_format($villa->average_rating, 1) }} / 5.0</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($reviews->count() > 0)
                            <div class="row g-4">
                                @foreach($reviews as $review)
                                    @include('components.review-item', ['review' => $review])
                                @endforeach
                            </div>
                            
                            @if($totalReviews > 5)
                                <div class="text-center mt-4">
                                    <button class="btn btn-outline-primary" id="loadMoreReviews" data-villa-id="{{ $villa->id }}">
                                        <i class="fas fa-chevron-down me-2"></i>
                                        Tüm Yorumları Göster ({{ $totalReviews - 5 }} yorum daha)
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="empty-reviews">
                                <i class="fas fa-comment-slash"></i>
                                <h5>Henüz yorum yapılmamış</h5>
                                <p>Bu villa için ilk yorumu siz yapın!</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Similar Villas -->
                @if($similarVillas->count() > 0)
                    <div class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-home"></i>Benzer Villalar</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                @foreach($similarVillas as $similarVilla)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="similar-villa-card card">
                                            <img src="{{ $similarVilla->primaryImage->url }}" 
                                                 alt="{{ $similarVilla->title }}" 
                                                 class="card-img-top">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $similarVilla->title }}</h6>
                                                <p class="card-text">
                                                    <i class="fas fa-map-marker-alt me-1"></i> 
                                                    {{ $similarVilla->location->name }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">{{ number_format($similarVilla->price_per_night, 0, ',', '.') }} ₺</span>
                                                    <a href="{{ route('villas.show', $similarVilla->slug) }}" class="btn btn-primary btn-sm">
                                                        Detaylar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Booking Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="h4 fw-bold text-primary">{{ number_format($villa->price_per_night, 0, ',', '.') }} ₺</span>
                                <span class="text-muted">/ gece</span>
                            </div>
                            @if($villa->review_count > 0)
                                <div class="text-end">
                                    {!! $villa->star_rating !!}
                                    <div class="small text-muted">{{ $villa->review_count }} değerlendirme</div>
                                </div>
                            @endif
                        </div>
                        
                        @if(auth()->check())
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('realtor'))
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Rezervasyon oluşturmak için müşteri hesabınızla giriş yapın.
                                </div>
                            @else
                                <form action="{{ route('bookings.create', $villa) }}" method="GET">
                                    <div class="mb-3">
                                        <label for="check_in" class="form-label">Giriş Tarihi</label>
                                        <input type="date" class="form-control" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="check_out" class="form-label">Çıkış Tarihi</label>
                                        <input type="date" class="form-control" id="check_out" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="guests" class="form-label">Misafir Sayısı</label>
                                        <input type="number" class="form-control" id="guests" name="guests" 
                                               min="1" max="{{ $villa->capacity }}" value="1" required>
                                        <div class="form-text">Maksimum {{ $villa->capacity }} misafir</div>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-calendar-check me-2"></i> Rezervasyon Yap
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('bookings.create', $villa) }}" method="GET">
                                <div class="mb-3">
                                    <label for="check_in" class="form-label">Giriş Tarihi</label>
                                    <input type="date" class="form-control" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="check_out" class="form-label">Çıkış Tarihi</label>
                                    <input type="date" class="form-control" id="check_out" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="guests" class="form-label">Misafir Sayısı</label>
                                    <input type="number" class="form-control" id="guests" name="guests" 
                                           min="1" max="{{ $villa->capacity }}" value="1" required>
                                    <div class="form-text">Maksimum {{ $villa->capacity }} misafir</div>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i> Rezervasyon Yap
                                    </button>
                                </div>
                            </form>
                        @endif
                        
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="mb-2">
                                <i class="fas fa-phone-alt me-2 text-primary"></i> +90 (212) 555 66 77
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-envelope me-2 text-primary"></i> info@villaland.com
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Availability Calendar -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Müsaitlik Takvimi
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('components.availability-calendar', ['villa' => $villa])
                    </div>
                </div>
                
                <!-- Map -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Konum
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($villa->latitude && $villa->longitude)
                            <div class="ratio ratio-4x3">
                                <iframe
                                    src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_api_key') }}&q={{ $villa->latitude }},{{ $villa->longitude }}&zoom=15"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                            <div class="mt-3">
                                <p class="mb-2 text-muted">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    {{ $villa->location->name }}
                                </p>
                                <p class="mb-0 small text-muted">
                                    {{ $villa->address }}
                                </p>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> 
                                Harita koordinatları henüz eklenmemiş.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Immediate execution test
console.log('=== SLIDESHOW DEBUG START ===');

// Global slideshow variables
let currentSlide = 0;
let isHovered = false; // Mouse hover state
let slideInterval;
let slides, thumbnails, container, progressBar, currentSlideSpan;

console.log('=== SLIDESHOW VARIABLES INITIALIZED ===');
console.log('Initial currentSlide:', currentSlide);
console.log('Initial isHovered:', isHovered);

// Navigation functions - Explicitly attach to window
window.nextSlide = function() {
    console.log('Next slide clicked');
    if (!slides || slides.length === 0) return false;
    currentSlide = (currentSlide + 1) % slides.length;
    updateSlideshow();
    return false;
};

window.prevSlide = function() {
    console.log('Previous slide clicked');
    if (!slides || slides.length === 0) return false;
    currentSlide = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
    updateSlideshow();
    return false;
};

window.goToSlide = function(index) {
    console.log('Going to slide:', index);
    if (!slides || slides.length === 0) return false;
    currentSlide = parseInt(index);
    updateSlideshow();
    return false;
};

// Mouse hover effects - Explicitly attach to window
window.pauseOnHover = function() {
    console.log('Mouse entered slideshow - pausing');
    isHovered = true;
};

window.resumeOnLeave = function() {
    console.log('Mouse left slideshow - resuming');
    isHovered = false;
};

// Lightbox functionality
let lightboxCurrentSlide = 0;
let lightboxInterval;
let lightboxPaused = false;
let lightboxImages = [];

window.openLightbox = function() {
    console.log('Opening lightbox');
    
    // Prepare lightbox images
    lightboxImages = [];
    const villaImages = document.querySelectorAll('.slide img');
    villaImages.forEach((img, index) => {
        lightboxImages.push({
            src: img.src,
            alt: img.alt
        });
    });
    
    if (lightboxImages.length === 0) return false;
    
    // Set current slide to match main slideshow
    lightboxCurrentSlide = currentSlide;
    
    // Create lightbox slides
    const lightboxSlides = document.getElementById('lightboxSlides');
    lightboxSlides.innerHTML = '';
    
    lightboxImages.forEach((image, index) => {
        const slide = document.createElement('div');
        slide.className = `lightbox-slide ${index === lightboxCurrentSlide ? 'active' : ''}`;
        slide.innerHTML = `<img src="${image.src}" alt="${image.alt}">`;
        lightboxSlides.appendChild(slide);
    });
    
    // Show lightbox
    const modal = document.getElementById('lightboxModal');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('active');
    }, 10);
    
    // Update counter
    updateLightboxCounter();
    
    // Start lightbox slideshow
    startLightboxSlideshow();
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
    
    return false;
};

window.closeLightbox = function() {
    console.log('Closing lightbox');
    
    const modal = document.getElementById('lightboxModal');
    modal.classList.remove('active');
    
    setTimeout(() => {
        modal.style.display = 'none';
        // Restore body scroll
        document.body.style.overflow = '';
        
        // Clear lightbox interval
        if (lightboxInterval) {
            clearInterval(lightboxInterval);
            lightboxInterval = null;
        }
    }, 300);
    
    return false;
};

window.lightboxNextSlide = function() {
    console.log('Lightbox next slide');
    lightboxCurrentSlide = (lightboxCurrentSlide + 1) % lightboxImages.length;
    updateLightboxSlides();
    return false;
};

window.lightboxPrevSlide = function() {
    console.log('Lightbox previous slide');
    lightboxCurrentSlide = lightboxCurrentSlide === 0 ? lightboxImages.length - 1 : lightboxCurrentSlide - 1;
    updateLightboxSlides();
    return false;
};

window.toggleLightboxSlideshow = function() {
    console.log('Toggle lightbox slideshow');
    
    if (lightboxPaused) {
        // Resume
        lightboxPaused = false;
        startLightboxSlideshow();
        document.getElementById('lightboxPlayIcon').className = 'fas fa-pause';
    } else {
        // Pause
        lightboxPaused = true;
        if (lightboxInterval) {
            clearInterval(lightboxInterval);
            lightboxInterval = null;
        }
        document.getElementById('lightboxPlayIcon').className = 'fas fa-play';
    }
    
    return false;
};

function updateLightboxSlides() {
    const slides = document.querySelectorAll('.lightbox-slide');
    slides.forEach((slide, index) => {
        slide.classList.toggle('active', index === lightboxCurrentSlide);
    });
    updateLightboxCounter();
}

function updateLightboxCounter() {
    const currentSpan = document.querySelector('.lightbox-current');
    if (currentSpan) {
        currentSpan.textContent = lightboxCurrentSlide + 1;
    }
}

function startLightboxSlideshow() {
    if (lightboxInterval) {
        clearInterval(lightboxInterval);
        lightboxInterval = null;
    }
    
    if (!lightboxPaused) {
        lightboxInterval = setInterval(() => {
            if (!lightboxPaused) {
                window.lightboxNextSlide();
            }
        }, 3000);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing slideshow...');
    
    // Initialize slideshow first
    initializeSlideshow();
    
    // Date validation for booking form
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(nextDay.getDate() + 1);
            
            const year = nextDay.getFullYear();
            const month = String(nextDay.getMonth() + 1).padStart(2, '0');
            const day = String(nextDay.getDate()).padStart(2, '0');
            
            checkOutInput.min = `${year}-${month}-${day}`;
            
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = `${year}-${month}-${day}`;
            }
        });
    }
    
    // Load more reviews
    const loadMoreBtn = document.getElementById('loadMoreReviews');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewsContainer = document.querySelector('.reviews-container .row');
            
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Yükleniyor...';
            this.disabled = true;
            
            fetch(`/villas/{{ $villa->slug }}/reviews`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reviewsContainer.innerHTML = data.html;
                        this.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = '<i class="fas fa-chevron-down me-2"></i>Tüm Yorumları Göster';
                    this.disabled = false;
                });
        });
    }
});

function initializeSlideshow() {
    console.log('=== INITIALIZING SLIDESHOW ===');
    
    const slideshow = document.getElementById('villaSlideshow');
    if (!slideshow) {
        console.error('Slideshow element not found!');
        return;
    }
    
    // Initialize slideshow state
    currentSlide = 0;
    isHovered = false;
    if (slideInterval) {
        clearInterval(slideInterval);
        slideInterval = null;
    }
    
    container = slideshow.querySelector('.slideshow-container');
    slides = slideshow.querySelectorAll('.slide');
    thumbnails = slideshow.querySelectorAll('.thumbnail');
    progressBar = slideshow.querySelector('.progress-bar');
    currentSlideSpan = slideshow.querySelector('.current-slide');
    
    console.log('Found elements:');
    console.log('- Container:', container);
    console.log('- Slides:', slides.length);
    console.log('- Thumbnails:', thumbnails.length);
    console.log('- Current slide set to:', currentSlide);
    console.log('- isHovered set to:', isHovered);
    
    if (slides.length === 0) {
        console.error('No slides found!');
        return;
    }
    
    // Initialize slideshow display and start auto slideshow
    console.log('Calling updateSlideshow...');
    updateSlideshow();
    console.log('Calling startAutoSlide...');
    startAutoSlide();
    
    // Verify slideshow started correctly
    setTimeout(() => {
        console.log('=== INITIALIZATION VERIFICATION ===');
        console.log('- isHovered:', isHovered);
        console.log('- slideInterval active:', slideInterval !== null);
        console.log('- Expected behavior: slideshow RUNNING, pauses on mouse hover');
    }, 200);
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Check if lightbox is open
        const lightboxModal = document.getElementById('lightboxModal');
        const isLightboxOpen = lightboxModal && lightboxModal.classList.contains('active');
        
        if (isLightboxOpen) {
            // Lightbox keyboard controls
            switch(e.key) {
                case 'Escape':
                    e.preventDefault();
                    window.closeLightbox();
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    window.lightboxPrevSlide();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    window.lightboxNextSlide();
                    break;
                case ' ':
                    e.preventDefault();
                    window.toggleLightboxSlideshow();
                    break;
            }
        } else {
            // Main slideshow keyboard controls
            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    window.prevSlide();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    window.nextSlide();
                    break;
            }
        }
    });
    
    console.log('=== SLIDESHOW INITIALIZATION COMPLETE ===');
}

// Update slideshow display
function updateSlideshow() {
    if (!slides || slides.length === 0) return;
    
    console.log('Updating to slide:', currentSlide);
    
    // Update active states for slides
    slides.forEach((slide, index) => {
        slide.classList.toggle('active', index === currentSlide);
        console.log(`Slide ${index} active:`, index === currentSlide);
    });
    
    // Update active states for thumbnails
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.classList.toggle('active', index === currentSlide);
    });
    
    // Update progress bar
    if (progressBar) {
        const progressPercentage = ((currentSlide + 1) / slides.length) * 100;
        progressBar.style.setProperty('width', `${progressPercentage}%`, 'important');
    }
    
    // Update counter
    if (currentSlideSpan) {
        currentSlideSpan.textContent = currentSlide + 1;
    }
    
    console.log('Slideshow updated - current slide index:', currentSlide, 'display number:', currentSlide + 1);
}

// Auto slideshow
function startAutoSlide() {
    console.log('=== STARTING AUTO SLIDESHOW ===');
    
    // ALWAYS clear any existing interval first to prevent multiple intervals
    if (slideInterval) {
        clearInterval(slideInterval);
        slideInterval = null;
    }
    
    // Start slideshow - will pause automatically on hover
    slideInterval = setInterval(() => {
        if (!isHovered && slides && slides.length > 0) {
            window.nextSlide();
        }
    }, 2500);
    console.log('Auto slideshow started with 2.5s interval - will pause on hover');
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing slideshow...');
    
    // Initialize slideshow first
    initializeSlideshow();
    
    // Date validation for booking form
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(nextDay.getDate() + 1);
            
            const year = nextDay.getFullYear();
            const month = String(nextDay.getMonth() + 1).padStart(2, '0');
            const day = String(nextDay.getDate()).padStart(2, '0');
            
            checkOutInput.min = `${year}-${month}-${day}`;
            
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = `${year}-${month}-${day}`;
            }
        });
    }
    
    // Load more reviews
    const loadMoreBtn = document.getElementById('loadMoreReviews');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewsContainer = document.querySelector('.reviews-container .row');
            
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Yükleniyor...';
            this.disabled = true;
            
            fetch(`/villas/{{ $villa->slug }}/reviews`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reviewsContainer.innerHTML = data.html;
                        this.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = '<i class="fas fa-chevron-down me-2"></i>Tüm Yorumları Göster';
                    this.disabled = false;
                });
        });
    }
});

console.log('=== SLIDESHOW DEBUG END ===');
</script>
@endpush
