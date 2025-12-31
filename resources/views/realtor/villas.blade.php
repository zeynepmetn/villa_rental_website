@extends('layouts.realtor')

@section('title', 'Villalarım')

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

    .text-gray-800 {
        color: #5a5c69 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Villa Yönetimi</h1>
        <a href="{{ route('realtor.villas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Yeni Villa Ekle
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('realtor.dashboard') }}">Dashboard</a></li>
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
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Tümü</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Pasif</option>
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
                    <a href="{{ route('realtor.villas') }}" class="btn btn-secondary">
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
                            <th>Detaylar</th>
                            <th class="text-center">Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($villas as $villa)
                        <tr>
                            <td>
                                <span class="badge badge-primary">#{{ $villa->id }}</span>
                            </td>
                            <td>
                                <img src="{{ $villa->primaryImage->url }}" 
                                     alt="{{ $villa->title }}" 
                                     class="img-thumbnail"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('villas.show', $villa->slug) }}" class="text-primary font-weight-bold" target="_blank">
                                        {{ $villa->title }}
                                        <i class="fas fa-external-link-alt fa-xs ml-1"></i>
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $villa->location->name }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="font-weight-bold">{{ number_format($villa->price_per_night, 2) }} ₺</span>
                                    <br>
                                    <small class="text-muted">Gecelik</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-bed"></i> {{ $villa->bedrooms }} Yatak Odası
                                    <br>
                                    <i class="fas fa-bath"></i> {{ $villa->bathrooms }} Banyo
                                    <br>
                                    <i class="fas fa-users"></i> {{ $villa->capacity }} Kişilik
                                    <br>
                                    <i class="fas fa-vector-square"></i> {{ $villa->size }} m²
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="status_{{ $villa->id }}" 
                                           {{ $villa->is_active ? 'checked' : '' }}
                                           disabled>
                                    <label class="custom-control-label" for="status_{{ $villa->id }}">
                                        {{ $villa->is_active ? 'Aktif' : 'Pasif' }}
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('realtor.villas.edit', $villa) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteVilla({{ $villa->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $villas->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Villa Sil</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bu villayı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteVilla(villaId) {
    const form = document.getElementById('deleteForm');
    form.action = `/realtor/villas/${villaId}`;
    
    // Show modal using Bootstrap 5 syntax
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Form elemanlarını dinle
    const filterForm = document.getElementById('filterForm');
    const formElements = filterForm.querySelectorAll('select, input[type="text"]');

    formElements.forEach(element => {
        element.addEventListener('change', function() {
            filterForm.submit();
        });
    });

    // Status toggle işlemi (realtor panelinde disabled olduğu için çalışmaz)
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endsection 