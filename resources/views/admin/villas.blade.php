@extends('layouts.admin')

@section('title', 'Villa Yönetimi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Villa Yönetimi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Villa Yönetimi</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold gradient-text">Filtrele</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.villas') }}" method="GET" class="row">
                <div class="col-md-2 mb-2">
                    <label for="location">Lokasyon</label>
                    <select class="form-control form-control-sm" id="location" name="location">
                        <option value="">Tümü</option>
                        @foreach($globalLocations as $location)
                        <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2 mb-2">
                    <label for="status">Durum</label>
                    <select class="form-control form-control-sm" id="status" name="status">
                        <option value="">Tümü</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Pasif</option>
                    </select>
                </div>
                
                <div class="col-md-2 mb-2">
                    <label for="featured">Öne Çıkan</label>
                    <select class="form-control form-control-sm" id="featured" name="featured">
                        <option value="">Tümü</option>
                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Evet</option>
                        <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Hayır</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-2">
                    <label for="sort">Fiyata Göre Sırala</label>
                    <select class="form-control form-control-sm" id="sort" name="sort">
                        <option value="">Varsayılan</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Artan Fiyat</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Azalan Fiyat</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-2">
                    <label for="search">Ara</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Villa adı veya ID..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Villas Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold gradient-text">Tüm Villalar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Görsel</th>
                            <th>Villa Adı</th>
                            <th>Lokasyon</th>
                            <th>Emlakçı</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>Öne Çıkan</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($villas as $villa)
                        <tr>
                            <td>{{ $villa->id }}</td>
                            <td>
                                <img src="{{ $villa->primaryImage->url }}" alt="{{ $villa->title }}" class="img-thumbnail" width="80">
                            </td>
                            <td>
                                <a href="{{ route('villas.show', $villa->slug) }}" target="_blank" class="font-weight-bold text-primary">
                                    {{ $villa->title }}
                                </a>
                            </td>
                            <td>{{ $villa->location->name }}</td>
                            <td>{{ $villa->realtor->name }}</td>
                            <td>{{ number_format($villa->price_per_night, 0, ',', '.') }} ₺</td>
                            <td>
                                <form action="{{ route('admin.villas.status', $villa) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input status-toggle" id="status_{{ $villa->id }}" name="is_active" value="1" {{ $villa->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_{{ $villa->id }}"></label>
                                    </div>
                                </form>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.villas.featured', $villa) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="btn btn-sm btn-star {{ $villa->is_featured ? 'btn-warning' : 'btn-outline-warning' }}"
                                            title="{{ $villa->is_featured ? 'Öne çıkarmaktan çıkar' : 'Öne çıkar' }}"
                                            style="min-width: 40px;">
                                        <i class="fas fa-star {{ $villa->is_featured ? 'text-white' : '' }}"></i>
                                    </button>
                                </form>
                                @if($villa->is_featured)
                                    <small class="d-block text-warning mt-1 status-label">
                                        <i class="fas fa-crown"></i> Öne Çıkan
                                    </small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Herhangi bir villa bulunamadı.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $villas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Status toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const statusToggles = document.querySelectorAll('.status-toggle');
        
        statusToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
@endsection
