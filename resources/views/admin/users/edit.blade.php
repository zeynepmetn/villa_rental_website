@extends('layouts.admin')

@section('title', 'Kullanıcı Düzenle')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kullanıcı Düzenle</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Kullanıcı Yönetimi</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <!-- User Information -->
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Kullanıcı Bilgileri</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">İsim Soyisim <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">E-posta Adresi <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">Telefon Numarası</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Yeni Şifre <small class="text-muted">(Boş bırakılırsa değişmez)</small></label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Yeni Şifre Tekrar</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                                
                                <div class="form-group">
                                    <label for="role">Kullanıcı Rolü <span class="text-danger">*</span></label>
                                    <select class="form-control" id="role" name="role" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="customer" {{ $user->hasRole('customer') ? 'selected' : '' }}>Müşteri</option>
                                        <option value="realtor" {{ $user->hasRole('realtor') ? 'selected' : '' }}>Emlakçı</option>
                                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Yönetici</option>
                                    </select>
                                    @if($user->id === auth()->id())
                                        <small class="text-muted">Kendi rolünüzü değiştiremezsiniz.</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Adres</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Geri Dön
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold gradient-text">Kullanıcı İstatistikleri</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Kayıt Tarihi</small>
                        <div>{{ $user->created_at->format('d.m.Y H:i') }}</div>
                    </div>

                    @if($user->hasRole('customer'))
                        <div class="mb-3">
                            <small class="text-muted">Toplam Rezervasyon</small>
                            <div>{{ $user->bookings()->count() }}</div>
                        </div>
                    @endif

                    @if($user->hasRole('realtor'))
                        <div class="mb-3">
                            <small class="text-muted">Toplam Villa</small>
                            <div>{{ $user->villas()->count() }}</div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Son Giriş</small>
                        <div>{{ $user->last_login_at ? $user->last_login_at->format('d.m.Y H:i') : 'Henüz Giriş Yapmadı' }}</div>
                    </div>

                    @if($user->id !== auth()->id())
                        <hr>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz? Bu işlem geri alınamaz!')">
                                <i class="fas fa-trash mr-1"></i> Kullanıcıyı Sil
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Form validation and phone number formatting can be added here
</script>
@endsection 