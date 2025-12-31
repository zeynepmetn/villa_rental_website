@extends('layouts.app')

@section('title', 'Giriş Yap')
@section('body_class', 'auth-page')

@push('styles')
<style>
/* Auth sayfalarında footer margin'ini sıfırla */
.auth-page footer {
    margin-top: 0 !important;
}

.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    padding: 100px 1rem 2rem 1rem; /* navbar için üstten boşluk */
}

.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.auth-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    text-align: center;
}

.auth-header h2 {
    margin: 0;
    font-weight: 700;
    font-size: 1.6rem;
}

.auth-header p {
    margin: 0.3rem 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.auth-body {
    padding: 1.5rem;
}

.form-floating {
    margin-bottom: 1rem;
}

.form-floating .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem;
    height: auto;
    transition: all 0.3s ease;
}

.form-floating .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-floating label {
    color: #6c757d;
    font-weight: 500;
}

.btn-auth {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    width: 100%;
    margin: 1rem 0;
}

.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.form-check {
    margin: 1.5rem 0;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.auth-links {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.auth-links a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.auth-links a:hover {
    color: #764ba2;
}

.demo-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    margin-top: 2rem;
}

.demo-header {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    padding: 1rem;
    border-radius: 15px 15px 0 0;
    text-align: center;
    font-weight: 600;
}

.demo-content {
    padding: 1.5rem;
}

.demo-item-flex {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.demo-item-flex:last-child {
    border-bottom: none;
}

.demo-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
    color: white;
    flex-shrink: 0;
}

.demo-text {
    flex: 1;
}

.demo-text h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #495057;
}

.demo-text .small {
    color: #6c757d;
    line-height: 1.4;
}

.demo-admin { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
.demo-realtor { background: linear-gradient(135deg, #28a745 0%, #218838 100%); }
.demo-customer { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }

.demo-item h6 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #495057;
}

.demo-item .small {
    color: #6c757d;
    line-height: 1.4;
}

@media (max-width: 768px) {
    .auth-container {
        padding: 100px 1rem 1rem 1rem;
    }
    
    .auth-header {
        padding: 1.2rem;
    }
    
    .auth-body {
        padding: 1.5rem 1rem;
    }
    
    .demo-content {
        padding: 1rem;
    }
    
    .demo-item-flex {
        padding: 0.75rem 0;
    }
    
    .demo-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-right: 0.75rem;
    }
}
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2><i class="fas fa-home me-2"></i>VillaLand'e Hoş Geldiniz</h2>
                        <p>Lüks villa dünyasına giriş yapın</p>
                    </div>

                    <div class="auth-body">
                        @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" placeholder="E-posta adresiniz" 
                                       value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label for="email"><i class="fas fa-envelope me-2"></i>E-posta Adresi</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Şifreniz" 
                                       required autocomplete="current-password">
                                <label for="password"><i class="fas fa-lock me-2"></i>Şifre</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Beni Hatırla
                                </label>
                            </div>

                            <button type="submit" class="btn btn-auth">
                                <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                            </button>

                            <div class="auth-links">
                                <p class="mb-2">
                                    <a href="{{ route('password.request') }}">
                                        <i class="fas fa-key me-1"></i>Şifremi Unuttum
                                    </a>
                                </p>
                                <p class="mb-0">
                                    Hesabınız yok mu? 
                                    <a href="{{ route('register') }}">
                                        <strong>Kayıt Ol</strong>
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Demo Hesaplar -->
                <div class="demo-card">
                    <div class="demo-header">
                        <i class="fas fa-info-circle me-2"></i>Demo Hesapları
                    </div>
                    <div class="demo-content">
                        <div class="demo-item-flex">
                            <div class="demo-icon demo-admin">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="demo-text">
                                <h6>Admin</h6>
                                <p class="small mb-1"><strong>admin@villaland.com</strong></p>
                                <p class="small mb-0">Şifre: <strong>123456</strong></p>
                            </div>
                        </div>
                        
                        <div class="demo-item-flex">
                            <div class="demo-icon demo-realtor">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="demo-text">
                                <h6>Emlakçı</h6>
                                <p class="small mb-1"><strong>realtor@villaland.com</strong></p>
                                <p class="small mb-0">Şifre: <strong>123456</strong></p>
                            </div>
                        </div>
                        
                        <div class="demo-item-flex">
                            <div class="demo-icon demo-customer">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="demo-text">
                                <h6>Müşteri</h6>
                                <p class="small mb-1"><strong>customer@villaland.com</strong></p>
                                <p class="small mb-0">Şifre: <strong>123456</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
