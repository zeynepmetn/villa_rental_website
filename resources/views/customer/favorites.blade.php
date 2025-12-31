@extends('layouts.customer')

@section('title', 'Favori Villalarım - VillaLand')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Favori Villalarım</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Favoriler</li>
            </ol>
        </div>
        <a href="{{ route('villas.index') }}" class="btn btn-primary">
            <i class="fas fa-search mr-2"></i>Villa Keşfet
        </a>
    </div>

    @if($favoriteVillas->count() > 0)
    <!-- Favorites Grid -->
    <div class="favorites-grid">
        @foreach($favoriteVillas as $villa)
        <div class="villa-card">
            <div class="villa-image">
                <img src="{{ $villa->main_image ?? 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                     alt="{{ $villa->title }}">
                <div class="villa-actions">
                    <button class="action-btn favorite-btn active" onclick="removeFromFavorites({{ $villa->id }})" 
                            style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-heart"></i>
                    </button>
                    <a href="{{ route('villas.show', $villa->slug) }}" class="action-btn view-btn"
                       style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @if($villa->featured)
                <div class="villa-badge">
                    <span class="badge bg-warning">
                        <i class="fas fa-star me-1"></i>Öne Çıkan
                    </span>
                </div>
                @endif
            </div>
            
            <div class="villa-content">
                <div class="villa-header">
                    <h4>{{ $villa->title }}</h4>
                    <div class="villa-rating">
                        @if($villa->average_rating)
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $villa->average_rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-text">({{ $villa->reviews_count ?? 0 }})</span>
                        @endif
                    </div>
                </div>
                
                <div class="villa-location">
                    <i class="fas fa-map-marker-alt me-2"></i>
                                                {{ $villa->address }}
                </div>
                
                <div class="villa-features">
                    <div class="feature-item">
                        <i class="fas fa-bed me-1"></i>
                        {{ $villa->bedrooms }} Yatak Odası
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-bath me-1"></i>
                        {{ $villa->bathrooms }} Banyo
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users me-1"></i>
                                                                {{ $villa->capacity }} Kişi
                    </div>
                </div>
                
                @if($villa->amenities && count($villa->amenities) > 0)
                <div class="villa-amenities">
                    @foreach(array_slice($villa->amenities, 0, 3) as $amenity)
                    <span class="amenity-tag">{{ $amenity }}</span>
                    @endforeach
                    @if(count($villa->amenities) > 3)
                    <span class="amenity-more">+{{ count($villa->amenities) - 3 }} daha</span>
                    @endif
                </div>
                @endif
                
                <div class="villa-footer">
                    <div class="villa-price">
                        <span class="price-amount">₺{{ number_format($villa->price_per_night, 0, ',', '.') }}</span>
                        <span class="price-period">/gece</span>
                    </div>
                    <div class="villa-actions-footer">
                        <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-outline-primary btn-sm">
                            Detaylar
                        </a>
                        <a href="{{ route('bookings.create', $villa->slug) }}" class="btn btn-primary btn-sm">
                            Rezervasyon
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-heart"></i>
        </div>
        <h3>Henüz favori villanız yok</h3>
        <p>Beğendiğiniz villaları favorilerinize ekleyerek kolayca erişebilirsiniz. Villa detay sayfalarında kalp ikonuna tıklayarak favorilerinize ekleyebilirsiniz.</p>
        <div class="empty-actions">
            <a href="{{ route('villas.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-search me-2"></i>Villa Keşfet
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-home me-2"></i>Ana Sayfa
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.favorites-container {
    padding: 2rem 0;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1.5rem;
    padding: 3rem;
    color: white;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

/* Favorites Grid */
.favorites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

.villa-card {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.villa-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.villa-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.villa-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.villa-card:hover .villa-image img {
    transform: scale(1.05);
}

.villa-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.9);
    color: #6b7280;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn:hover {
    background: white;
    transform: scale(1.1);
}

.favorite-btn.active {
    color: #ef4444;
}

.view-btn:hover {
    color: #667eea;
}

.villa-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
}

.villa-content {
    padding: 1.5rem;
}

.villa-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.villa-header h4 {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    flex: 1;
}

.villa-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating-stars {
    color: #fbbf24;
    font-size: 0.875rem;
}

.rating-text {
    font-size: 0.875rem;
    color: #6b7280;
}

.villa-location {
    color: #6b7280;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.villa-features {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.feature-item {
    font-size: 0.875rem;
    color: #6b7280;
    display: flex;
    align-items: center;
}

.villa-amenities {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.amenity-tag {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.amenity-more {
    color: #6b7280;
    font-size: 0.75rem;
    font-style: italic;
}

.villa-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.villa-price {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
}

.price-amount {
    font-size: 1.25rem;
    font-weight: 700;
    color: #667eea;
}

.price-period {
    font-size: 0.875rem;
    color: #6b7280;
}

.villa-actions-footer {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
}

.empty-state h3 {
    color: #1f2937;
    margin-bottom: 1rem;
    font-size: 1.75rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
    font-size: 1.1rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.empty-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-header {
        padding: 2rem;
    }
    
    .favorites-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .villa-header {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .villa-features {
        gap: 0.5rem;
    }
    
    .villa-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .villa-actions-footer {
        justify-content: center;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 576px) {
    .favorites-container {
        padding: 1rem 0;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .villa-content {
        padding: 1rem;
    }
    
    .villa-image {
        height: 200px;
    }
    
    .empty-state {
        padding: 2rem 1rem;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function removeFromFavorites(villaId) {
    if (confirm('Bu villayı favorilerinizden kaldırmak istediğinizden emin misiniz?')) {
        fetch(`/customer/favorites/${villaId}/remove`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the villa card from the page
                const villaCard = document.querySelector(`[onclick="removeFromFavorites(${villaId})"]`).closest('.villa-card');
                villaCard.style.transition = 'all 0.3s ease';
                villaCard.style.opacity = '0';
                villaCard.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    villaCard.remove();
                    
                    // Check if there are any villas left
                    const remainingVillas = document.querySelectorAll('.villa-card');
                    if (remainingVillas.length === 0) {
                        // Show empty state without reloading
                        showEmptyState();
                    }
                }, 300);
                
                // Show success message with global notification system
                console.log('Checking notification systems...');
                console.log('window.CustomerNotification:', window.CustomerNotification);
                console.log('showCustomNotification function:', typeof showCustomNotification);
                
                if (window.CustomerNotification) {
                    console.log('Using CustomerNotification system');
                    window.CustomerNotification.success(data.message || 'Villa favorilerden kaldırıldı.');
                } else {
                    console.log('Using showCustomNotification fallback');
                    showCustomNotification(data.message || 'Villa favorilerden kaldırıldı.', 'success');
                }
            } else {
                if (window.CustomerNotification) {
                    window.CustomerNotification.error('Bir hata oluştu. Lütfen tekrar deneyin.');
                } else {
                    showCustomNotification('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (window.CustomerNotification) {
                window.CustomerNotification.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            } else {
                showCustomNotification('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            }
        });
    }
}

function showEmptyState() {
    // Replace the favorites grid with empty state
    const favoritesGrid = document.querySelector('.favorites-grid');
    if (favoritesGrid) {
        favoritesGrid.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Henüz favori villanız yok</h3>
                    <p>Beğendiğiniz villaları favorilerinize ekleyerek kolayca erişebilirsiniz. Villa detay sayfalarında kalp ikonuna tıklayarak favorilerinize ekleyebilirsiniz.</p>
                    <div class="empty-actions">
                        <a href="{{ route('villas.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Villa Keşfet
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Ana Sayfa
                        </a>
                    </div>
                </div>
            </div>
        `;
    }
}

function showNotification(message, type) {
    // Use the global notification system
    if (window.FavoriteSystem && window.FavoriteSystem.showNotification) {
        window.FavoriteSystem.showNotification(message, type);
        return;
    }
    
    // Fallback notification system
    const existingNotifications = document.querySelectorAll('.favorite-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed favorite-notification`;
    notification.style.cssText = 'bottom: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

function showCustomNotification(message, type) {
    // Remove any existing notifications
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed custom-notification`;
    notification.style.cssText = 'bottom: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2 fs-5"></i>
            <div class="flex-grow-1">
                <strong>${type === 'success' ? 'Başarılı!' : 'Hata!'}</strong><br>
                <small>${message}</small>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 150);
        }
    }, 4000);
}
</script>
@endpush 