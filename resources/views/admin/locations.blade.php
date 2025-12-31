@extends('layouts.admin')

@section('title', 'Lokasyon Yönetimi')

@section('styles')
<style>
    .gradient-text {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .filter-form {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 20px;
    }

    .filter-row {
        display: flex;
        gap: 20px;
        align-items: end;
        flex-wrap: wrap;
    }

    .filter-item {
        flex: 1;
        min-width: 200px;
    }

    .filter-item label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 5px;
        display: block;
    }

    .btn-primary {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
        background: linear-gradient(45deg, #1cc88a 0%, #13855c 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-warning {
        background: linear-gradient(45deg, #f6c23e 0%, #dda20a 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-danger {
        background: linear-gradient(45deg, #e74a3b 0%, #c0392b 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-secondary {
        background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }

    .table th {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .badge {
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-success {
        background: linear-gradient(45deg, #1cc88a 0%, #13855c 100%);
    }

    .badge-secondary {
        background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
    }

    .badge-info {
        background: linear-gradient(45deg, #36b9cc 0%, #258391 100%);
    }

    .card {
        transition: transform 0.2s ease;
        border: 1px solid #e3e6f0;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .modal-lg {
        max-width: 900px;
    }

    .form-check-input {
        cursor: pointer;
    }

    .form-check-label {
        cursor: pointer;
        user-select: none;
    }

    /* Custom File Input Styling */
    .upload-area {
        border: 2px dashed #e3e6f0;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: #fff;
    }

    .upload-area:hover {
        border-color: #667eea;
        background-color: #f8f9fc;
    }

    .upload-zone-active {
        border-color: #667eea !important;
        background-color: #f8f9fc !important;
    }

    .upload-area input[type="file"] {
        display: none;
    }

    .upload-content {
        text-align: center;
        padding: 2rem 1rem;
    }

    .upload-icon {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .upload-title {
        font-size: 1rem;
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }

    .upload-subtitle {
        font-size: 0.85rem;
        color: #858796;
        margin-bottom: 1rem;
    }

    .upload-button {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 6px;
        color: white;
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .upload-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .file-preview-area {
        margin-top: 1rem;
        text-align: center;
    }

    .preview-image {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        border: 2px solid #e3e6f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .file-info {
        margin-top: 0.75rem;
        font-size: 0.9rem;
        color: #5a5c69;
        font-weight: 500;
    }

    .remove-file-btn {
        margin-top: 0.5rem;
        background: #dc3545;
        border: none;
        border-radius: 4px;
        color: white;
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .remove-file-btn:hover {
        background: #c82333;
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Lokasyon Yönetimi</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLocationModal">
            <i class="fas fa-plus"></i> Yeni Lokasyon Ekle
        </button>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Lokasyon Yönetimi</li>
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
            <form action="" method="GET" class="filter-form">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="search">Ara</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Lokasyon adı..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <label for="popular">Popülerlik</label>
                        <select class="form-control" id="popular" name="popular">
                            <option value="">Tümü</option>
                            <option value="1" {{ request('popular') == '1' ? 'selected' : '' }}>Popüler</option>
                            <option value="0" {{ request('popular') == '0' ? 'selected' : '' }}>Normal</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="sort">Sıralama</label>
                        <select class="form-control" id="sort" name="sort">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>İsim (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>İsim (Z-A)</option>
                            <option value="villas_desc" {{ request('sort') == 'villas_desc' ? 'selected' : '' }}>Villa Sayısı (Çok-Az)</option>
                            <option value="villas_asc" {{ request('sort') == 'villas_asc' ? 'selected' : '' }}>Villa Sayısı (Az-Çok)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Locations List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold gradient-text">Tüm Lokasyonlar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Görsel</th>
                            <th>Lokasyon Adı</th>
                            <th>Villa Sayısı</th>
                            <th>Popüler</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $location)
                        <tr>
                            <td>{{ $location->id }}</td>
                            <td>
                                @if($location->image)
                                    <img src="{{ Storage::url($location->image) }}" alt="{{ $location->name }}" class="img-thumbnail" width="80">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light" style="width: 80px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="font-weight-bold text-primary">{{ $location->name }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $location->villas_count }} Villa
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.locations.toggle-popular', $location) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $location->is_popular ? 'btn-success' : 'btn-secondary' }}">
                                        @if($location->is_popular)
                                            <i class="fas fa-star"></i> Popüler
                                        @else
                                            <i class="far fa-star"></i> Normal
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.locations.edit', $location) }}" 
                                       class="btn btn-sm btn-primary"
                                       title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($location->villas_count == 0)
                                    <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bu lokasyonu silmek istediğinize emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Henüz lokasyon bulunmuyor.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $locations->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationModalLabel">Yeni Lokasyon Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.locations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="name">Lokasyon Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="description">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="3" style="resize: none !important; height: auto !important;"></textarea>
                    </div>
                    
                    <div class="form-group mb-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_popular" name="is_popular" value="1">
                            <label class="custom-control-label" for="is_popular">Popüler Lokasyon</label>
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="image">Lokasyon Görseli</label>
                        <div class="upload-area" id="uploadZone">
                            <input type="file" id="image" name="image" accept="image/*">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <h6 class="upload-title">Lokasyon Görseli Yükle</h6>
                                <p class="upload-subtitle">PNG, JPG veya JPEG (Max 20MB)</p>
                                <button type="button" class="upload-button" onclick="document.getElementById('image').click();">
                                    <i class="fas fa-plus me-1"></i> Dosya Seç
                                </button>
                            </div>
                        </div>
                        <div class="file-preview-area" id="filePreview" style="display: none;">
                            <img id="previewImage" class="preview-image" src="" alt="Önizleme">
                            <div class="file-info" id="fileName"></div>
                            <button type="button" class="remove-file-btn" id="removeFileBtn">
                                <i class="fas fa-times me-1"></i> Kaldır
                            </button>
                        </div>
                        <small class="form-text text-muted">Maksimum dosya boyutu: 2MB. Desteklenen formatlar: JPG, PNG, JPEG</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Lokasyon Ekle</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter form auto-submit
    const filterForm = document.querySelector('.filter-form');
    const filterInputs = filterForm.querySelectorAll('select, input[type="text"]');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', () => filterForm.submit());
    });

    // Custom File Input Functionality
    const fileInput = document.getElementById('image');
    const uploadZone = document.getElementById('uploadZone');
    const filePreview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const removeFileBtn = document.getElementById('removeFileBtn');

    // File input change event
    fileInput.addEventListener('change', function(e) {
        handleFileSelect(e.target.files[0]);
    });

    // Drag and drop functionality
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('upload-zone-active');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('upload-zone-active');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('upload-zone-active');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                fileInput.files = files;
                handleFileSelect(file);
            }
        }
    });

    // Remove file button
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        resetFileInput();
    });

    function handleFileSelect(file) {
        if (file) {
            // Show preview below upload area (don't modify upload area)
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                fileName.textContent = file.name;
                filePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            resetFileInput();
        }
    }

    function resetFileInput() {
        filePreview.style.display = 'none';
        previewImage.src = '';
        fileName.textContent = '';
    }

    // Reset file input when modal is closed
    $('#addLocationModal').on('hidden.bs.modal', function() {
        fileInput.value = '';
        resetFileInput();
    });

    // Edit location functionality
    $('.edit-location-btn').on('click', function() {
        const button = $(this);
        const id = button.data('id');
        
        // Show loading state
        const modalBody = $('#editLocationModal .modal-body');
        modalBody.html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><div class="mt-2">Yükleniyor...</div></div>');
        
        // Fetch location data using the new route
        $.get(`/admin/locations/${id}/data`)
            .done(function(response) {
                if (response.success) {
                    window.location.href = `/admin/locations/${id}/edit`;
                } else {
                    alert('Lokasyon bilgileri alınamadı.');
                }
            })
            .fail(function() {
                alert('Lokasyon bilgileri alınırken bir hata oluştu.');
            });
    });
});
</script>
@endsection 