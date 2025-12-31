@extends('layouts.customer')

@section('title', 'Yorum Yap')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Yorum Yap</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.reviews.index') }}">Yorumlarım</a></li>
            <li class="breadcrumb-item active">Yorum Yap</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star me-2"></i>
                        Konaklama Deneyiminizi Değerlendirin
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Booking Info -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="{{ $booking->villa->main_image }}" 
                                 alt="{{ $booking->villa->title }}" 
                                 class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $booking->villa->title }}</h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $booking->villa->location->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Konaklama Tarihi:</strong> 
                                {{ $booking->check_in->format('d.m.Y') }} - {{ $booking->check_out->format('d.m.Y') }}
                                ({{ $booking->nights }} gece)
                            </p>
                            <p class="mb-2">
                                <strong>Toplam Tutar:</strong> {{ number_format($booking->total_price, 2) }} ₺
                            </p>
                            <p class="mb-0">
                                <strong>Rezervasyon ID:</strong> #{{ $booking->id }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Review Form -->
                    <form action="{{ route('customer.reviews.store', $booking) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="rating" class="form-label">
                                <strong>Genel Değerlendirme</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="star-rating-input" id="starRating">
                                <input type="hidden" name="rating" id="ratingValue" value="{{ old('rating') }}">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star" data-rating="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <small class="form-text text-muted">Konaklama deneyiminizi 1-5 yıldız arasında değerlendirin</small>
                            </div>
                            @error('rating')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label">
                                <strong>Yorumunuz</strong>
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="comment" 
                                      id="comment" 
                                      class="form-control @error('comment') is-invalid @enderror" 
                                      rows="6" 
                                      placeholder="Konaklama deneyiminizi detaylı olarak anlatın. Villanın temizliği, konumu, olanakları hakkında görüşlerinizi paylaşın..."
                                      maxlength="1000">{{ old('comment') }}</textarea>
                            <div class="form-text">
                                <span id="charCount">0</span>/1000 karakter
                            </div>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Bilgi:</strong> Yorumunuz admin onayından sonra villa detay sayfasında yayınlanacaktır.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.reviews.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Geri Dön
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Yorumu Gönder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-lightbulb me-2"></i>
                        Yorum Yazma İpuçları
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Villanın temizliği hakkında bilgi verin
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Konumun avantaj ve dezavantajlarını belirtin
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Olanakların (havuz, bahçe vb.) durumunu açıklayın
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Ev sahibi ile iletişim deneyiminizi paylaşın
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success me-2"></i>
                            Diğer misafirlere tavsiyelerinizi yazın
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .star-rating-input .stars {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .star-rating-input .star {
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
        margin-right: 0.25rem;
    }
    
    .star-rating-input .star:hover,
    .star-rating-input .star.active {
        color: #ffc107;
    }
    
    .star-rating-input .star.hover {
        color: #ffc107;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('ratingValue');
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('charCount');
    
    // Star rating functionality
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingValue.value = rating;
            updateStars(rating);
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = this.getAttribute('data-rating');
            highlightStars(rating);
        });
    });
    
    document.querySelector('.stars').addEventListener('mouseleave', function() {
        const currentRating = ratingValue.value;
        updateStars(currentRating);
    });
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('active');
                star.classList.remove('hover');
            } else {
                star.classList.remove('active', 'hover');
            }
        });
    }
    
    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('hover');
            } else {
                star.classList.remove('hover');
            }
        });
    }
    
    // Character count
    function updateCharCount() {
        const count = commentTextarea.value.length;
        charCount.textContent = count;
        
        if (count > 900) {
            charCount.style.color = '#dc3545';
        } else if (count > 800) {
            charCount.style.color = '#ffc107';
        } else {
            charCount.style.color = '#6c757d';
        }
    }
    
    commentTextarea.addEventListener('input', updateCharCount);
    
    // Initialize
    updateCharCount();
    if (ratingValue.value) {
        updateStars(ratingValue.value);
    }
});
</script>
@endpush 