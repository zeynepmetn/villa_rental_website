@extends('layouts.admin')

@section('title', 'Yeni Villa Ekle')

@section('styles')
<style>
    .gradient-text {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-label {
        font-weight: 500;
        color: #4a5568;
    }

    .card {
        transition: transform 0.2s ease;
        border: 1px solid #e3e6f0;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
    }

    .btn-secondary:hover {
        background: linear-gradient(45deg, #5a6268 0%, #3d4043 100%);
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
    }

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
        max-width: 150px;
        max-height: 100px;
        border-radius: 8px;
        border: 2px solid #e3e6f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 0.5rem;
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

    .badge {
        font-size: 0.8rem;
        padding: 0.35rem 0.5rem;
    }

    .preview-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Yeni Villa Ekle</h1>
        <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.villas.index') }}">Villa Yönetimi</a></li>
        <li class="breadcrumb-item active">Yeni Villa Ekle</li>
    </ol>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.villas.store') }}" method="POST" enctype="multipart/form-data" id="villaForm">
        @csrf
        <div class="row">
            <!-- Sol Panel -->
            <div class="col-lg-8">
                <!-- Temel Bilgiler -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Temel Bilgiler</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="title" class="form-label">Villa Adı <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label">Açıklama <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5" style="height: 120px !important; min-height: 120px !important;" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="location_id" class="form-label">Lokasyon <span class="text-danger">*</span></label>
                                <select class="form-control" id="location_id" name="location_id" required>
                                    <option value="">Seçiniz</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="realtor_id" class="form-label">Emlakçı <span class="text-danger">*</span></label>
                                <select class="form-control" id="realtor_id" name="realtor_id" required>
                                    <option value="">Seçiniz</option>
                                    @foreach($realtors as $realtor)
                                    <option value="{{ $realtor->id }}" {{ old('realtor_id') == $realtor->id ? 'selected' : '' }}>
                                        {{ $realtor->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detay Bilgileri -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Detay Bilgileri</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="bedrooms" class="form-label">Yatak Odası <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bed"></i></span>
                                    <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="bathrooms" class="form-label">Banyo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bath"></i></span>
                                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="capacity" class="form-label">Kapasite <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="size" class="form-label">Büyüklük (m²) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-vector-square"></i></span>
                                    <input type="number" class="form-control" id="size" name="size" value="{{ old('size') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="address" class="form-label">Adres <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="5" style="height: 120px !important; min-height: 120px !important;" required>{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="latitude" class="form-label">Enlem <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="number" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" step="any" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="longitude" class="form-label">Boylam <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="number" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" step="any" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Görseller -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Görseller</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-3 text-primary">
                                <i class="fas fa-plus-circle me-2"></i>Villa Görselleri
                            </h6>
                            <div class="upload-area" id="uploadZone">
                                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <h6 class="upload-title">Görselleri Buraya Sürükleyin</h6>
                                    <p class="upload-subtitle">veya dosya seçmek için tıklayın</p>
                                    <button type="button" class="upload-button" onclick="document.getElementById('images').click();">
                                        <i class="fas fa-images me-2"></i>Dosya Seç
                                    </button>
                                    <div class="mt-2">
                                        <small class="text-muted">PNG, JPG, JPEG • Max 20MB • En fazla 6 fotoğraf</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="file-preview-area" id="filePreview" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-success">
                                        <i class="fas fa-check-circle me-2"></i>Seçilen Görseller
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileBtn">
                                        <i class="fas fa-trash me-1"></i>Tümünü Kaldır
                                    </button>
                                </div>
                                <div id="previewContainer" class="row"></div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>İpucu:</strong> Kapak fotoğrafı seçmek isteğe bağlıdır. Daha sonra villa düzenleme sayfasından değiştirebilirsiniz.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ Panel -->
            <div class="col-lg-4">
                <!-- Fiyatlandırma -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Fiyatlandırma</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="price_per_night" class="form-label">Gecelik Fiyat <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₺</span>
                                <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Durum -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Durum</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Öne Çıkan</label>
                        </div>
                    </div>
                </div>

                <!-- Özellikler -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Özellikler</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($features as $feature)
                                <div class="col-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}"
                                            {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature{{ $feature->id }}">
                                            {{ $feature->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">En fazla 10 özellik seçebilirsiniz.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom File Input Functionality
    const fileInput = document.getElementById('images');
    const uploadArea = document.getElementById('uploadZone');
    const filePreview = document.getElementById('filePreview');
    const previewContainer = document.getElementById('previewContainer');
    const removeFileBtn = document.getElementById('removeFileBtn');
    let selectedFiles = [];

    // File input change event
    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        // Maksimum 6 fotoğraf kontrolü
        if (files.length > 6) {
            alert('Maksimum 6 fotoğraf seçebilirsiniz.');
            this.value = '';
            return;
        }
        
        selectedFiles = files;
        handleFileSelect();
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
        
        const files = Array.from(e.dataTransfer.files);
        if (files.length > 0) {
            // Maksimum 6 fotoğraf kontrolü
            if (files.length > 6) {
                alert('Maksimum 6 fotoğraf seçebilirsiniz.');
                return;
            }
            
            selectedFiles = files;
            // Update the file input
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
            handleFileSelect();
        }
    });

    // Remove file button
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        selectedFiles = [];
        resetFileInput();
    });

    function handleFileSelect() {
        if (selectedFiles && selectedFiles.length > 0) {
            previewContainer.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-4 mb-3';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top preview-image" alt="Önizleme" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="primary_image_index" value="${index}" id="primary_${index}">
                                        <label class="form-check-label" for="primary_${index}">
                                            <small><i class="fas fa-star text-warning"></i> Kapak Fotoğrafı</small>
                                        </label>
                                    </div>
                                    <small class="text-muted d-block text-truncate">${file.name}</small>
                                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-single-image" data-index="${index}">
                                        <i class="fas fa-times"></i> Kaldır
                                    </button>
                                </div>
                            </div>
                        `;
                        previewContainer.appendChild(col);
                        
                        // Add remove single image event
                        col.querySelector('.remove-single-image').addEventListener('click', function() {
                            const indexToRemove = parseInt(this.dataset.index);
                            selectedFiles.splice(indexToRemove, 1);
                            updateFileInput();
                            handleFileSelect();
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            filePreview.style.display = 'block';
        } else {
            resetFileInput();
        }
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    function resetFileInput() {
        filePreview.style.display = 'none';
        previewContainer.innerHTML = '';
    }

    // Form submission - add primary image index as hidden input
    document.getElementById('villaForm').addEventListener('submit', function(e) {
        // Get selected primary image index if any
        const primaryRadio = document.querySelector('input[name="primary_image_index"]:checked');
        if (primaryRadio) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'primary_image_index';
            hiddenInput.value = primaryRadio.value;
            this.appendChild(hiddenInput);
        }
    });
});
</script>
@endpush 