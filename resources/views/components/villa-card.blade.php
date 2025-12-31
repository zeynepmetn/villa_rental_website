<div class="villa-card h-100">
    <div class="position-relative">
        <a href="{{ route('villas.show', $villa->slug) }}">
            <img src="{{ $villa->primaryImage->url }}" class="card-img-top villa-card-img" alt="{{ $villa->title }}">
        </a>
        <div class="position-absolute top-0 end-0 p-2">
            @if($villa->is_featured)
                <span class="badge bg-warning rounded-pill px-3 py-2 shadow-sm">
                    <i class="fas fa-star me-1"></i> Öne Çıkan
                </span>
            @endif
        </div>
        @auth
            @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('realtor'))
                <div class="position-absolute bottom-0 end-0 p-3">
                    <form id="favorite-form-{{ $villa->id }}" action="{{ route('villas.favorite', $villa) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="button" class="btn btn-light rounded-circle shadow-sm favorite-btn" 
                                data-villa-id="{{ $villa->id }}" 
                                data-villa-slug="{{ $villa->slug }}"
                                style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-heart {{ auth()->user()->hasFavorited($villa) ? 'text-danger' : 'text-muted' }}"></i>
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
    <div class="card-body p-4">
        <div class="text-center mb-3">
            <h5 class="villa-card-title">{{ $villa->title }}</h5>
            <div class="villa-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $villa->location->name }}</span>
            </div>
        </div>

        <div class="villa-features-grid">
            <div class="feature-item">
                <i class="fas fa-bed"></i>
                <span>{{ $villa->bedrooms }} yatak</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-bath"></i>
                <span>{{ $villa->bathrooms }} banyo</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-users"></i>
                <span>{{ $villa->capacity }} misafir</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-vector-square"></i>
                <span>{{ $villa->size }} m²</span>
            </div>
        </div>

        @if($villa->features && $villa->features->count())
            <div class="mb-3 text-center" style="margin-top: 1rem;">
                @php
                    $maxBadges = 4;
                    $featureCount = $villa->features->count();
                @endphp
                @foreach($villa->features->take($maxBadges) as $feature)
                    <span class="badge bg-primary text-white me-1 mb-1">{{ $feature->name }}</span>
                @endforeach
                @if($featureCount > $maxBadges)
                    <span class="badge me-1 mb-1" style="background: linear-gradient(90deg, #6366f1 0%, #a855f7 100%); color: #fff;">+{{ $featureCount - $maxBadges }}</span>
                @endif
            </div>
        @endif

        <div class="text-center mt-4">
            <div class="villa-price mb-3">
                <span class="price-amount">{{ number_format($villa->price_per_night, 0, ',', '.') }} ₺</span>
                <span class="price-period">/ gece</span>
            </div>
            <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-primary w-100">Detaylar</a>
        </div>
    </div>
</div>

{{-- Favorite functionality is now handled by global FavoriteSystem in app.blade.php --}}
