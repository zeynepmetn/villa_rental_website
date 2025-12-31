<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VillaLand') - VillaLand</title>
    <meta name="description" content="@yield('meta_description', 'VillaLand - Premium villa kiralama platformu. Tatil için en lüks ve konforlu villalar.')">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page specific CSS -->
    @stack('styles')
</head>
<body class="antialiased @yield('body_class')">
    <div id="app">
        @include('components.header')

        <main>
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Page specific scripts -->
    @stack('scripts')

    <!-- Global Favorite System -->
    <script>
    // Global favorite system to prevent duplicate event listeners
    window.FavoriteSystem = (function() {
        let isProcessing = false;
        let initialized = false;
        
        function init() {
            if (initialized) return;
            initialized = true;
            
            // Use event delegation to handle all favorite buttons
            document.addEventListener('click', function(e) {
                const favoriteBtn = e.target.closest('.favorite-btn');
                if (!favoriteBtn) return;
                
                handleFavoriteClick(e, favoriteBtn);
            });
        }
        
        function handleFavoriteClick(e, button) {
            e.preventDefault();
            e.stopPropagation();
            
            // Prevent multiple clicks
            if (isProcessing || button.disabled) {
                return;
            }
            
            isProcessing = true;
            
            const villaId = button.getAttribute('data-villa-id');
            const villaSlug = button.getAttribute('data-villa-slug');
            const heartIcon = button.querySelector('i');
            
            if (!villaSlug) {
                console.error('Villa slug not found');
                isProcessing = false;
                return;
            }
            
            // Disable button and add loading state
            button.disabled = true;
            button.style.opacity = '0.6';
            button.style.pointerEvents = 'none';
            
            fetch(`/villas/${villaSlug}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update all favorite buttons for this villa
                    updateAllFavoriteButtons(villaSlug, data.is_favorited);
                    
                    // Show success message
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message || 'Bir hata oluştu.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            })
            .finally(() => {
                // Re-enable all buttons for this villa
                const allButtons = document.querySelectorAll(`[data-villa-slug="${villaSlug}"]`);
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                });
                isProcessing = false;
            });
        }
        
        function updateAllFavoriteButtons(villaSlug, isFavorited) {
            const allButtons = document.querySelectorAll(`[data-villa-slug="${villaSlug}"]`);
            allButtons.forEach(button => {
                const heartIcon = button.querySelector('i');
                if (heartIcon) {
                    if (isFavorited) {
                        heartIcon.classList.remove('text-muted');
                        heartIcon.classList.add('text-danger');
                    } else {
                        heartIcon.classList.remove('text-danger');
                        heartIcon.classList.add('text-muted');
                    }
                }
            });
        }
        
        function showNotification(message, type) {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.favorite-notification');
            existingNotifications.forEach(notification => notification.remove());
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed favorite-notification`;
            notification.style.cssText = 'bottom: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }
        
            // Public API
    return {
        init: init,
        showNotification: showNotification
    };
    })();

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        window.FavoriteSystem.init();
    });
    </script>
</body>
</html>
