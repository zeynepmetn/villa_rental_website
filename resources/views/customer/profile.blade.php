@extends('layouts.customer')

@section('title', 'Profil Ayarları - VillaLand')

@push('styles')
<style>
    .profile-container {
        padding: 2rem 1.5rem;
        max-width: 1400px;
        margin: 0 auto;
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

    /* Profile Info Card */
    .profile-info-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .profile-avatar-section {
        margin-bottom: 2rem;
    }

    .avatar-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e5e7eb;
    }

    .avatar-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        background: #667eea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: 3px solid white;
        cursor: pointer;
    }

    .profile-avatar-section h4 {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .member-since {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .customer-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-top: 1rem;
    }

    .profile-stats {
        display: flex;
        justify-content: space-around;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
        margin-top: auto;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    /* Profile Form Card */
    .profile-form-card,
    .password-change-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        width: 100%;
    }

    .card-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-header h5 {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }

    .input-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .input-icon {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 3;
        font-size: 0.875rem;
    }

    .form-control {
        padding: 0.625rem 0.875rem 0.625rem 2.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: #f9fafb;
        height: auto;
        min-height: 40px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .text-danger {
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Avatar Upload */
    .avatar-upload {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-start;
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn-lg {
        padding: 0.625rem 1.5rem;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        font-weight: 600;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    }

    /* Password Form */
    .password-change-card {
        margin-top: 2rem;
    }

    .password-form .input-group {
        margin-bottom: 1.25rem;
    }

    .password-form .btn-lg {
        margin-top: 1rem;
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 2rem;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6b7280;
    }

    .alert {
        border: none;
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem 0.75rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .page-subtitle {
            font-size: 0.95rem;
        }
        
        .page-header {
            padding: 1.5rem 1rem;
            margin-bottom: 1.5rem;
        }
        
        .page-header .col-lg-4 {
            margin-top: 1rem;
        }
        
        .profile-info-card,
        .profile-form-card,
        .password-change-card {
            padding: 1.25rem;
        }
        
        .profile-stats {
            flex-direction: row;
            gap: 0.5rem;
        }
        
        .stat-item {
            flex: 1;
        }
        
        .stat-number {
            font-size: 1.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-lg {
            width: 100%;
            padding: 0.75rem 1rem;
        }
        
        .row.g-4 {
            gap: 1rem !important;
        }
        
        .password-change-card {
            margin-top: 1.5rem;
        }
        
        .password-form .row.g-4 .col-md-4 {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .profile-container {
            padding: 0.75rem 0.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .page-subtitle {
            font-size: 0.875rem;
        }
        
        .page-header {
            padding: 1.25rem 0.75rem;
            text-align: center;
        }
        
        .page-header .row {
            flex-direction: column;
        }
        
        .page-header .col-lg-4 {
            margin-top: 0.75rem;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
        }
        
        .avatar-overlay {
            width: 30px;
            height: 30px;
        }
        
        .profile-info-card,
        .profile-form-card,
        .password-change-card {
            padding: 1rem;
        }
        
        .profile-stats {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .stat-item {
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
        }
        
        .card-header h5 {
            font-size: 1.1rem;
        }
        
        .form-label {
            font-size: 0.8rem;
        }
        
        .form-control {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem 0.5rem 2.25rem;
        }
        
        .input-icon {
            left: 0.75rem;
            font-size: 0.8rem;
        }
        
        .btn-lg {
            font-size: 0.8rem;
            padding: 0.625rem 1rem;
        }
        
        .breadcrumb {
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="page-title">Profil Ayarları</h1>
                <p class="page-subtitle">Müşteri hesap bilgilerinizi ve güvenlik ayarlarınızı yönetin</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end gap-3">
                    <div class="text-center">
                        <div class="h4 mb-0">👤</div>
                        <small>Müşteri Profili</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil Ayarları</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row g-4 align-items-stretch">
        <!-- Profile Info Card -->
        <div class="col-lg-4 d-flex">
            <div class="profile-info-card">
                <div class="profile-avatar-section">
                    <div class="avatar-container">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=667eea&color=fff&size=120' }}" 
                             alt="{{ $user->name }}" class="profile-avatar" id="avatarPreview">
                        <div class="avatar-overlay" onclick="document.getElementById('avatarInput').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    <div class="customer-badge">
                        <i class="fas fa-user me-2"></i>VillaLand Müşterisi
                    </div>
                    <div class="member-since">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Üye: {{ $user->created_at->format('M Y') }}
                    </div>
                </div>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $totalBookings ?? 0 }}</div>
                        <div class="stat-label">Toplam Rezervasyon</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $completedBookings ?? 0 }}</div>
                        <div class="stat-label">Tamamlanan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $favoriteCount ?? 0 }}</div>
                        <div class="stat-label">Favori Villa</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-lg-8 d-flex">
            <div class="profile-form-card">
                <div class="card-header">
                    <h5>Kişisel Bilgiler</h5>
                    <p class="text-muted">Profil bilgilerinizi güncelleyin</p>
                </div>

                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Avatar Upload -->
                        <div class="col-12">
                            <label class="form-label">Profil Fotoğrafı</label>
                            <div class="avatar-upload">
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('avatarInput').click()">
                                    <i class="fas fa-upload me-2"></i>Fotoğraf Yükle
                                </button>
                                <small class="text-muted d-block mt-2">JPG, PNG formatında, maksimum 2MB</small>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Ad Soyad</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">E-posta</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="form-label">Telefon</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+90 (555) 123 45 67">
                            </div>
                            @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <label class="form-label">Şehir</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}" placeholder="İstanbul, Türkiye">
                            </div>
                            @error('city')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div class="col-md-6">
                            <label class="form-label">Doğum Tarihi</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-birthday-cake"></i>
                                </span>
                                <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                            </div>
                            @error('birth_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label class="form-label">Cinsiyet</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-venus-mars"></i>
                                </span>
                                <select class="form-control" name="gender">
                                    <option value="">Seçiniz</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Erkek</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Kadın</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Diğer</option>
                                </select>
                            </div>
                            @error('gender')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="col-12">
                            <label class="form-label">Hakkımda</label>
                            <textarea class="form-control" name="bio" rows="4" placeholder="Kendiniz hakkında kısa bir açıklama yazın..." style="padding-left: 0.875rem;">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                                </button>
                                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>İptal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="password-change-card">
                <div class="card-header">
                    <h5>Şifre Değiştir</h5>
                    <p class="text-muted">Hesap güvenliğiniz için düzenli olarak şifrenizi değiştirin</p>
                </div>

                <form action="{{ route('customer.password.update') }}" method="POST" class="password-form">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Mevcut Şifre</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Yeni Şifre</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Yeni Şifre (Tekrar)</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-shield-alt me-2"></i>Şifreyi Güncelle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Avatar preview
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelector('.profile-form').addEventListener('submit', function(e) {
    const name = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    
    if (!name || !email) {
        e.preventDefault();
        alert('Ad Soyad ve E-posta alanları zorunludur.');
        return false;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Geçerli bir e-posta adresi girin.');
        return false;
    }
});

// Password form validation
document.querySelector('.password-form').addEventListener('submit', function(e) {
    const currentPassword = document.querySelector('input[name="current_password"]').value;
    const newPassword = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        e.preventDefault();
        alert('Tüm şifre alanları zorunludur.');
        return false;
    }
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Yeni şifreler eşleşmiyor.');
        return false;
    }
    
    if (newPassword.length < 8) {
        e.preventDefault();
        alert('Yeni şifre en az 8 karakter olmalıdır.');
        return false;
    }
});
</script>
@endpush 