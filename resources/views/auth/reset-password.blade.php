@extends('layouts.app')

@section('title', 'Şifre Sıfırlama')
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

.form-floating .form-control:disabled {
    background-color: #f8f9fa;
    opacity: 0.8;
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

.info-box {
    background: rgba(102, 126, 234, 0.1);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    color: #495057;
}

.info-box i {
    color: #667eea;
    margin-right: 0.5rem;
}

.password-help {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
}

.password-help i {
    margin-right: 0.5rem;
    color: #28a745;
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
                        <h2><i class="fas fa-lock me-2"></i>Şifre Sıfırlama</h2>
                        <p>Yeni şifrenizi belirleyin</p>
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

                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            Güvenliğiniz için güçlü bir şifre seçin. En az 8 karakter olmalıdır.
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $request->email }}">

                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" 
                                       value="{{ $request->email }}" disabled>
                                <label for="email"><i class="fas fa-envelope me-2"></i>E-posta Adresi</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Yeni şifreniz" 
                                       required autocomplete="new-password" autofocus>
                                <label for="password"><i class="fas fa-lock me-2"></i>Yeni Şifre</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="password-help">
                                    <i class="fas fa-info-circle"></i>
                                    En az 8 karakter olmalıdır
                                </div>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" placeholder="Şifre tekrar" 
                                       required autocomplete="new-password">
                                <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Şifre Tekrar</label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-auth">
                                <i class="fas fa-key me-2"></i>Şifreyi Sıfırla
                            </button>

                            <div class="auth-links">
                                <p class="mb-0">
                                    <a href="{{ route('login') }}">
                                        <i class="fas fa-arrow-left me-1"></i>Giriş Sayfasına Dön
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
