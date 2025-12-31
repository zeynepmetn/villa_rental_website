<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RealtorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\VillaController as AdminVillaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/villas', [VillaController::class, 'index'])->name('villas.index');
Route::get('/villas/{villa:slug}', [VillaController::class, 'show'])->name('villas.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Villa müsaitlik takvimi endpointi
Route::get('/villas/{villa:slug}/availability', [VillaController::class, 'availability'])->name('villas.availability');

// Villa yorumlarını yüklemek için AJAX endpoint
Route::get('/villas/{villa:slug}/reviews', [VillaController::class, 'loadAllReviews'])->name('villas.reviews');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Common dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Villa favorite functionality
    Route::post('/villas/{villa:slug}/favorite', [VillaController::class, 'toggleFavorite'])->name('villas.favorite');
    
    // Booking routes
    Route::get('/villas/{villa:slug}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/villas/{villa:slug}/book', [BookingController::class, 'store'])->name('bookings.store');
    
    // Customer routes
    Route::middleware('role:customer')->prefix('customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/bookings', [CustomerController::class, 'bookings'])->name('customer.bookings');
        Route::get('/bookings/{booking}', [CustomerController::class, 'showBooking'])->name('customer.bookings.show');
        Route::delete('/bookings/{booking}/cancel', [CustomerController::class, 'cancelBooking'])->name('customer.bookings.cancel');
        Route::get('/favorites', [CustomerController::class, 'favorites'])->name('customer.favorites');
        Route::post('/favorites/{villa}/add', [CustomerController::class, 'addToFavorites'])->name('customer.favorites.add');
        Route::delete('/favorites/{villa}/remove', [CustomerController::class, 'removeFromFavorites'])->name('customer.favorites.remove');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
        Route::put('/password', [CustomerController::class, 'updatePassword'])->name('customer.password.update');
        Route::get('/download-data', [CustomerController::class, 'downloadData'])->name('customer.download.data');
        Route::delete('/delete-account', [CustomerController::class, 'deleteAccount'])->name('customer.delete.account');
        
        // Review routes
        Route::get('/reviews', [\App\Http\Controllers\Customer\ReviewController::class, 'index'])->name('customer.reviews.index');
        Route::get('/bookings/{booking}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('customer.reviews.create');
        Route::post('/bookings/{booking}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('customer.reviews.store');
        Route::get('/reviews/{review}/edit', [\App\Http\Controllers\Customer\ReviewController::class, 'edit'])->name('customer.reviews.edit');
        Route::put('/reviews/{review}', [\App\Http\Controllers\Customer\ReviewController::class, 'update'])->name('customer.reviews.update');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\Customer\ReviewController::class, 'destroy'])->name('customer.reviews.destroy');
    });
    
    // Realtor routes
    Route::middleware('role:realtor')->prefix('realtor')->group(function () {
        Route::get('/dashboard', [RealtorController::class, 'dashboard'])->name('realtor.dashboard');
        Route::get('/villas', [RealtorController::class, 'villas'])->name('realtor.villas');
        Route::get('/villas/create', [RealtorController::class, 'createVilla'])->name('realtor.villas.create');
        Route::post('/villas', [RealtorController::class, 'storeVilla'])->name('realtor.villas.store');
        Route::get('/villas/{villa:slug}/edit', [RealtorController::class, 'editVilla'])->name('realtor.villas.edit');
        Route::put('/villas/{villa:slug}', [RealtorController::class, 'updateVilla'])->name('realtor.villas.update');
        Route::delete('/villas/{villa:slug}', [RealtorController::class, 'destroyVilla'])->name('realtor.villas.destroy');
        Route::post('/villas/{villa:slug}/images', [RealtorController::class, 'addImages'])->name('realtor.villas.images.store');
        Route::delete('/villas/images/{image}', [RealtorController::class, 'deleteImage'])->name('realtor.villas.images.destroy');
        Route::post('/villas/{villa:slug}/images/{imageId}/set-primary', [RealtorController::class, 'setPrimaryImage'])->name('realtor.villas.images.set-primary');
        Route::post('/villas/{villa:slug}/features', [RealtorController::class, 'updateFeatures'])->name('realtor.villas.features.update');
        Route::get('/bookings', [RealtorController::class, 'bookings'])->name('realtor.bookings');
        Route::get('/bookings/{booking}', [RealtorController::class, 'showBooking'])->name('realtor.bookings.show');
        Route::post('/bookings/{booking}/status', [RealtorController::class, 'updateBookingStatus'])->name('realtor.bookings.update');
        Route::delete('/villa-images/{image}', [RealtorController::class, 'deleteImage'])->name('realtor.villa-images.destroy');
        
        // Location Management
        Route::get('/locations', [RealtorController::class, 'locations'])->name('realtor.locations');
        Route::post('/locations', [RealtorController::class, 'storeLocation'])->name('realtor.locations.store');
        Route::get('/locations/{location}/edit', [RealtorController::class, 'editLocation'])->name('realtor.locations.edit');
        Route::put('/locations/{location}/update', [RealtorController::class, 'updateLocation'])->name('realtor.locations.update');
        Route::delete('/locations/{location}/delete', [RealtorController::class, 'destroyLocation'])->name('realtor.locations.destroy');
        Route::put('/locations/{location}/toggle-popular', [RealtorController::class, 'toggleLocationPopular'])->name('realtor.locations.toggle-popular');
        Route::get('/locations/{location}/data', [RealtorController::class, 'getLocation'])->name('realtor.locations.get');
        
        Route::get('/profile', [RealtorController::class, 'profile'])->name('realtor.profile');
        Route::put('/profile', [RealtorController::class, 'updateProfile'])->name('realtor.profile.update');
        Route::put('/password', [RealtorController::class, 'updatePassword'])->name('realtor.password.update');
    });
    
    // Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
        
        // Location Management
        Route::get('/locations', [AdminController::class, 'locations'])->name('locations');
        Route::post('/locations', [AdminController::class, 'storeLocation'])->name('locations.store');
        Route::get('/locations/{location}/edit', [AdminController::class, 'editLocation'])->name('locations.edit');
        Route::put('/locations/{location}/update', [AdminController::class, 'updateLocation'])->name('locations.update');
        Route::delete('/locations/{location}/delete', [AdminController::class, 'destroyLocation'])->name('locations.destroy');
        Route::put('/locations/{location}/toggle-popular', [AdminController::class, 'toggleLocationPopular'])->name('locations.toggle-popular');
        Route::get('/locations/{location}/data', [AdminController::class, 'getLocation'])->name('locations.get');

        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('profile.update');
        Route::put('/password', [AdminController::class, 'updatePassword'])->name('password.update');
        Route::get('/dashboard/stats/{year}', [AdminController::class, 'getYearlyStats'])->name('dashboard.stats');
        
        // Villa Management
        Route::get('/villas', [AdminVillaController::class, 'index'])->name('villas.index');
        Route::get('/villas/create', [AdminVillaController::class, 'create'])->name('villas.create');
        Route::post('/villas', [AdminVillaController::class, 'store'])->name('villas.store');
        Route::get('/villas/{villa:slug}', [AdminVillaController::class, 'show'])->name('villas.show');
        Route::get('/villas/{villa:slug}/edit', [AdminVillaController::class, 'edit'])->name('villas.edit');
        Route::put('/villas/{villa:slug}', [AdminVillaController::class, 'update'])->name('villas.update');
        Route::delete('/villas/{villa:slug}', [AdminVillaController::class, 'destroy'])->name('villas.destroy');
        Route::put('/villas/{villa:slug}/status', [AdminVillaController::class, 'updateStatus'])->name('villas.status');
        Route::put('/villas/{villa:slug}/featured', [AdminVillaController::class, 'toggleFeatured'])->name('villas.featured');
        Route::post('/villas/{villa:slug}/images/reorder', [AdminVillaController::class, 'updateImageOrder'])->name('villas.images.reorder');
        Route::post('/villas/{villa:slug}/images/{imageId}/primary', [AdminVillaController::class, 'setPrimaryImage'])->name('villas.images.primary');
        
        // Admin reviews
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::post('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('reviews.approve');
        Route::post('/reviews/{review}/reject', [AdminController::class, 'rejectReview'])->name('reviews.reject');
        Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
        
        // Contact Management
        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
        Route::get('/contacts/{contact}', [AdminController::class, 'showContact'])->name('contacts.show');
        Route::post('/contacts/{contact}/replied', [AdminController::class, 'markContactReplied'])->name('contacts.replied');
        Route::post('/contacts/{contact}/reply', [AdminController::class, 'sendContactReply'])->name('contacts.reply');
        Route::delete('/contacts/{contact}', [AdminController::class, 'deleteContact'])->name('contacts.delete');
    });
});




