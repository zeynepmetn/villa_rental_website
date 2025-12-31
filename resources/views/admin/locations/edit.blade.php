@extends('layouts.admin')

@section('title', 'Lokasyon Düzenle')

@section('styles')
<style>
    .gradient-text {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-primary {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        font-weight: 600;
        color: white !important;
    }

    .btn-secondary:hover {
        background: linear-gradient(45deg, #5a6268 0%, #3d4043 100%);
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
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

    .card {
        border: 1px solid #e3e6f0;
        border-radius: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .card-header {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        border-bottom: none;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #d1d3e2;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #667eea;
        border-color: #667eea;
    }

    .custom-control-input:focus ~ .custom-control-label::before {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .image-preview {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        border: 2px solid #e3e6f0;
    }

    .villa-card {
        transition: transform 0.2s ease;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
    }

    .villa-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .badge {
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-success {
        background: linear-gradient(45deg, #1cc88a 0%, #13855c 100%);
    }

    .badge-danger {
        background: linear-gradient(45deg, #e74a3b 0%, #c0392b 100%);
    }

    .badge-info {
        background: linear-gradient(45deg, #36b9cc 0%, #258391 100%);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d;
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

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .stats-card .stats-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .stats-card .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Lokasyon Düzenle</h1>
        <a href="{{ route('admin.locations') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Geri Dön
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.locations') }}">Lokasyonlar</a></li>
        <li class="breadcrumb-item active">{{ $location->name }}</li>
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

    <form action="{{ route('admin.locations.update', $location) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Sol Panel -->
            <div class="col-lg-8">
                <!-- Temel Bilgiler -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Temel Bilgiler</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Lokasyon Adı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $location->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      style="resize: none !important; height: auto !important;">{{ old('description', $location->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Görsel Yönetimi -->
                <div class="card shadow mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Görsel Yönetimi</h6>
                    </div>
                    <div class="card-body">
                        @if($location->image)
                        <div class="mb-3">
                            <label class="form-label">Mevcut Görsel</label>
                            <div>
                                <img src="{{ Storage::url($location->image) }}" alt="{{ $location->name }}" class="image-preview">
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="image">Yeni Görsel Yükle</label>
                            <div class="upload-area" id="uploadZone">
                                <input type="file" id="image" name="image" accept="image/*">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <h6 class="upload-title">Yeni Görsel Yükle</h6>
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
                            <small class="form-text text-muted">
                                Maksimum dosya boyutu: 2MB. Desteklenen formatlar: JPG, PNG, JPEG
                                @if($location->image)
                                <br><strong>Not:</strong> Yeni görsel yüklerseniz mevcut görsel silinecektir.
                                @endif
                            </small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ Panel -->
            <div class="col-lg-4">
                <!-- Ayarlar -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Ayarlar</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_popular" 
                                       name="is_popular" value="1" {{ old('is_popular', $location->is_popular) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_popular">
                                    <strong>Popüler Lokasyon</strong>
                                    <small class="d-block text-muted">Popüler lokasyonlar ana sayfada öne çıkar</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save mr-1"></i> Değişiklikleri Kaydet
                            </button>
                        </div>
                    </div>
                </div>

                <!-- İstatistikler -->
                <div class="card shadow mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">İstatistikler</h6>
                    </div>
                    <div class="card-body">
                        <div class="stats-card">
                            <div class="stats-number">{{ $location->villas->count() }}</div>
                            <div class="stats-label">Toplam Villa</div>
                        </div>

                        <div class="stats-card">
                            <div class="stats-number">{{ $location->villas->where('is_active', true)->count() }}</div>
                            <div class="stats-label">Aktif Villa</div>
                        </div>

                        <div class="stats-card">
                            <div class="stats-number">{{ $location->villas->where('is_featured', true)->count() }}</div>
                            <div class="stats-label">Öne Çıkan Villa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Villalar Listesi -->
    @if($villas->count() > 0)
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold gradient-text">Bu Lokasyondaki Villalar ({{ $location->villas->count() }})</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($villas as $villa)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card villa-card h-100">
                        @if($villa->images->where('is_primary', true)->first())
                        <img src="{{ $villa->images->where('is_primary', true)->first()->url }}" 
                             class="card-img-top" alt="{{ $villa->title }}" style="height: 200px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                        @endif
                        
                        <div class="card-body">
                            <h6 class="card-title">{{ $villa->title }}</h6>
                            <p class="card-text text-muted small">{{ Str::limit($villa->description, 80) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold text-primary">₺{{ number_format($villa->price_per_night) }}/gece</span>
                                <div>
                                    @if($villa->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                    @else
                                    <span class="badge badge-danger">Pasif</span>
                                    @endif
                                    
                                    @if($villa->is_featured)
                                    <span class="badge badge-info">Öne Çıkan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('admin.villas.edit', $villa->slug) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Düzenle
                            </a>
                            <a href="{{ route('villas.show', $villa->slug) }}" class="btn btn-sm btn-secondary" target="_blank">
                                <i class="fas fa-eye"></i> Görüntüle
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($villas->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $villas->links() }}
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom File Input Functionality
    const fileInput = document.getElementById('image');
    const uploadArea = document.getElementById('uploadZone');
    const filePreview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const removeFileBtn = document.getElementById('removeFileBtn');

    // File input change event
    fileInput.addEventListener('change', function(e) {
        handleFileSelect(e.target.files[0]);
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('upload-zone-active');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('upload-zone-active');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('upload-zone-active');
        
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
});
</script>
@endpush 