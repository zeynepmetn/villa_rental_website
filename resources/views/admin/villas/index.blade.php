@extends('layouts.admin')

@section('title', 'Villa Yönetimi')

@section('styles')
<style>
    .filter-form {
        margin-bottom: 1.5rem;
    }

    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .filter-item {
        flex: 1;
        min-width: 200px;
    }

    .filter-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .table th {
        font-weight: 600;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }

    .custom-switch {
        padding-left: 2.25rem;
    }

    .custom-control-label {
        padding-top: 2px;
    }

    .badge {
        padding: 0.5em 0.75em;
    }

    .gradient-text {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Filtreleme kutularının yüksekliği */
    .filter-form .form-control {
        height: calc(2.5em + 0.75rem + 2px) !important;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .filter-form .form-label {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Villa Yönetimi</h1>
        <a href="{{ route('admin.villas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Yeni Villa Ekle
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Villa Yönetimi</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filtreleme -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtrele</h6>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" class="filter-form">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="search" class="form-label">Arama</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Villa adı veya ID">
                    </div>
                    
                    <div class="filter-item">
                        <label for="location" class="form-label">Lokasyon</label>
                        <select class="form-control" id="location" name="location">
                            <option value="">Tümü</option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Tümü</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="featured" class="form-label">Öne Çıkan</label>
                        <select class="form-control" id="featured" name="featured">
                            <option value="">Tümü</option>
                            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Evet</option>
                            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Hayır</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="sort" class="form-label">Sıralama</label>
                        <select class="form-control" id="sort" name="sort">
                            <option value="id_asc" {{ request('sort', 'id_asc') == 'id_asc' ? 'selected' : '' }}>ID (Artan)</option>
                            <option value="id_desc" {{ request('sort') == 'id_desc' ? 'selected' : '' }}>ID (Azalan)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fiyat (Artan)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fiyat (Azalan)</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>İsim (A-Z)</option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>İsim (Z-A)</option>
                        </select>
                    </div>
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrele
                    </button>
                    <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Temizle
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Villa Listesi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold gradient-text">Villa Listesi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Görsel</th>
                            <th>Villa Bilgileri</th>
                            <th>Fiyat</th>
                            <th>Kapasite</th>
                            <th class="text-center">Durum</th>
                            <th class="text-center">Öne Çıkan</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('admin.villas.partials.villa-list')
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $villas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form elemanlarını dinle
    const filterForm = document.getElementById('filterForm');
    const formElements = filterForm.querySelectorAll('select, input[type="text"]');

    formElements.forEach(element => {
        element.addEventListener('change', function() {
            filterForm.submit();
        });
    });

    // Status toggle işlemi
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endpush 