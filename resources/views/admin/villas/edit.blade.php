@extends('layouts.admin')

@section('title', 'Villa Düzenle')

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
    transition: all 0.3s ease;
    border-radius: 12px !important;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
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

/* Custom File Input Styling */
.upload-area {
    border: 2px dashed #e3e6f0;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.upload-area::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.upload-area:hover {
    border-color: #667eea;
    background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.upload-area:hover::before {
    opacity: 1;
}

.upload-zone-active {
    border-color: #667eea !important;
    background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%) !important;
    transform: scale(1.02) !important;
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.2) !important;
}

.upload-area input[type="file"] {
    display: none;
}

.upload-content {
    text-align: center;
    padding: 3rem 2rem;
    position: relative;
    z-index: 2;
}

.upload-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1.5rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.upload-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #5a5c69;
    margin-bottom: 0.5rem;
}

.upload-subtitle {
    font-size: 0.9rem;
    color: #858796;
    margin-bottom: 1.5rem;
}

.upload-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    color: white;
    padding: 0.75rem 2rem;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.upload-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4c93 100%);
}

.file-preview-area {
    margin-top: 2rem;
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
    font-size: 0.75rem;
    padding: 0.4rem 0.6rem;
    border-radius: 6px;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.btn-outline-danger:hover {
    transform: scale(1.05);
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Villa Düzenle</h1>
        <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.villas.index') }}">Villa Yönetimi</a></li>
        <li class="breadcrumb-item active">Villa Düzenle</li>
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

    <form action="{{ route('admin.villas.update', $villa) }}" method="POST" enctype="multipart/form-data" id="editVillaForm">
        @csrf
        @method('PUT')
        
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
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $villa->title) }}" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label">Açıklama <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5" style="height: 120px !important; min-height: 120px !important;" required>{{ old('description', $villa->description) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="location_id" class="form-label">Lokasyon <span class="text-danger">*</span></label>
                                <select class="form-control" id="location_id" name="location_id" required>
                                    <option value="">Seçiniz</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id', $villa->location_id) == $location->id ? 'selected' : '' }}>
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
                                    <option value="{{ $realtor->id }}" {{ old('realtor_id', $villa->realtor_id) == $realtor->id ? 'selected' : '' }}>
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
                                    <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $villa->bedrooms) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="bathrooms" class="form-label">Banyo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bath"></i></span>
                                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $villa->bathrooms) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="capacity" class="form-label">Kapasite <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', $villa->capacity) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="size" class="form-label">Büyüklük (m²) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-vector-square"></i></span>
                                    <input type="number" class="form-control" id="size" name="size" value="{{ old('size', $villa->size) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="address" class="form-label">Adres <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="5" style="height: 120px !important; min-height: 120px !important;" required>{{ old('address', $villa->address) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="latitude" class="form-label">Enlem <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="number" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $villa->latitude) }}" step="any" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="longitude" class="form-label">Boylam <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="number" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $villa->longitude) }}" step="any" required>
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
                        <div class="row">
                            <!-- Sol Taraf - Yeni Görsel Yükleme -->
                            <div class="col-md-6">
                                <h6 class="font-weight-bold mb-3 text-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Yeni Görsel Ekle
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
                                
                                <!-- Yeni Görseller Önizleme -->
                                <div class="file-preview-area" id="filePreview" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 text-success">
                                            <i class="fas fa-check-circle me-2"></i>Yüklenecek Görseller
                                        </h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileBtn">
                                            <i class="fas fa-trash me-1"></i>Tümünü Kaldır
                                        </button>
                                    </div>
                                    <div id="previewContainer" class="row"></div>
                                </div>
                            </div>

                            <!-- Sağ Taraf - Mevcut Görseller -->
                            <div class="col-md-6">
                                @if($villa->images->count() > 0)
                                <h6 class="font-weight-bold mb-3 text-info">
                                    <i class="fas fa-images me-2"></i>Mevcut Görseller ({{ $villa->images->count() }})
                                </h6>
                                <div class="row" id="existingImages">
                                    @foreach($villa->images as $index => $image)
                                    <div class="col-12 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="row g-0">
                                                <div class="col-4">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image->path) }}" 
                                                             class="img-fluid rounded-start"
                                                             alt="Villa görsel"
                                                             style="height: 80px; width: 100%; object-fit: cover;"
                                                             onerror="this.src='{{ asset('images/villa-placeholder.jpg') }}'">
                                                        
                                                        @if($image->is_primary)
                                                        <div class="position-absolute top-0 start-0 m-1">
                                                            <span class="badge bg-success px-2 py-1">
                                                                <i class="fas fa-star"></i>
                                                            </span>
                                                        </div>
                                                        @endif
                                                        
                                                        <div class="position-absolute bottom-0 end-0 m-1">
                                                            <span class="badge bg-primary">{{ $index + 1 }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body p-2">
                                                        <div class="row g-1">
                                                            <div class="col-12 mb-1">
                                                                <div class="form-check">
                                                                    <input type="radio" 
                                                                           class="form-check-input" 
                                                                           id="primary_image_{{ $image->id }}" 
                                                                           name="primary_image" 
                                                                           value="{{ $image->id }}"
                                                                           {{ $image->is_primary ? 'checked' : '' }}>
                                                                    <label class="form-check-label text-success fw-bold small" for="primary_image_{{ $image->id }}">
                                                                        <i class="fas fa-star me-1"></i>Kapak Yap
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input type="checkbox" 
                                                                           class="form-check-input" 
                                                                           id="delete_image_{{ $image->id }}" 
                                                                           name="delete_images[]" 
                                                                           value="{{ $image->id }}">
                                                                    <label class="form-check-label text-danger fw-bold small" for="delete_image_{{ $image->id }}">
                                                                        <i class="fas fa-trash me-1"></i>Sil
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted">Henüz görsel eklenmemiş</h6>
                                    <p class="text-muted small">Soldan görsel ekleyebilirsiniz</p>
                                </div>
                                @endif
                            </div>
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
                                <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $villa->price_per_night) }}" min="0" step="0.01" required>
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
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $villa->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $villa->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Öne Çıkan</label>
                        </div>
                    </div>
                </div>

                <!-- Özellikler -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold gradient-text">Özellikler</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($features as $feature)
                                <div class="col-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}"
                                            {{ $villa->features->contains('id', $feature->id) ? 'checked' : '' }}>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
// Global feature management functions
window.addFeature = function() {
    const container = document.getElementById('features-container');
    if (!container) return;
    
    const newFeature = document.createElement('div');
    newFeature.className = 'input-group mb-2';
    newFeature.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="Özellik ekle">
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(newFeature);
};

window.removeFeature = function(button) {
    const featureItem = button.closest('.input-group');
    if (featureItem) {
        featureItem.remove();
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Initialize features container
    const featuresContainer = document.getElementById('features-container');
    if (featuresContainer) {
        // Add click event delegation for remove buttons
        featuresContainer.addEventListener('click', function(e) {
            const removeButton = e.target.closest('.btn-outline-danger');
            if (removeButton) {
                removeFeature(removeButton);
            }
        });
    }

    // Görsel yükleme kodu
    const imageInput = document.getElementById('images');
    const newImages = document.getElementById('filePreview');
    const previewArea = document.getElementById('previewContainer');
    const uploadZone = document.getElementById('uploadZone');
    const removeFileBtn = document.getElementById('removeFileBtn');
    let selectedFiles = [];

    // File input change event
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const existingImagesCount = {{ $villa->images->count() }};
            
            // Maksimum 6 fotoğraf kontrolü (mevcut + yeni)
            if (files.length > 6) {
                alert('Maksimum 6 fotoğraf seçebilirsiniz.');
                this.value = '';
                return;
            }
            
            if (existingImagesCount + files.length > 6) {
                alert(`Toplam maksimum 6 fotoğraf olabilir. Şu anda ${existingImagesCount} fotoğraf var, en fazla ${6 - existingImagesCount} yeni fotoğraf ekleyebilirsiniz.`);
                this.value = '';
                return;
            }
            
            selectedFiles = files;
            handleFileSelect();
        });
    }

    // Drag and drop handlers
    if (uploadZone) {
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
            
            const files = Array.from(e.dataTransfer.files);
            const existingImagesCount = {{ $villa->images->count() }};
            
            if (files.length > 0) {
                // Maksimum 6 fotoğraf kontrolü
                if (files.length > 6) {
                    alert('Maksimum 6 fotoğraf seçebilirsiniz.');
                    return;
                }
                
                if (existingImagesCount + files.length > 6) {
                    alert(`Toplam maksimum 6 fotoğraf olabilir. Şu anda ${existingImagesCount} fotoğraf var, en fazla ${6 - existingImagesCount} yeni fotoğraf ekleyebilirsiniz.`);
                    return;
                }
                
                selectedFiles = files;
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                imageInput.files = dt.files;
                handleFileSelect();
            }
        });
    }

    // Remove file button
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            imageInput.value = '';
            selectedFiles = [];
            resetFileInput();
        });
    }

    function handleFileSelect() {
        if (selectedFiles && selectedFiles.length > 0) {
            previewArea.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-12 mb-2';
                        col.innerHTML = `
                            <div class="card border-0 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <div class="position-relative">
                                            <img src="${e.target.result}" class="img-fluid rounded-start" alt="Önizleme" style="height: 80px; width: 100%; object-fit: cover;">
                                            <div class="position-absolute top-0 start-0 m-1">
                                                <span class="badge bg-warning text-dark px-1 py-1">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                            </div>
                                            <div class="position-absolute bottom-0 end-0 m-1">
                                                <span class="badge bg-secondary">${index + 1}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-2">
                                            <div class="row g-1 mb-1">
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="new_primary_image_index" value="${index}" id="new_primary_${index}">
                                                        <label class="form-check-label text-success fw-bold small" for="new_primary_${index}">
                                                            <i class="fas fa-star me-1"></i>Kapak Yap
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted text-truncate me-2">${file.name}</small>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-single-image" data-index="${index}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        previewArea.appendChild(col);
                        
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
            
            newImages.style.display = 'block';
        } else {
            resetFileInput();
        }
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        imageInput.files = dt.files;
    }

    function resetFileInput() {
        newImages.style.display = 'none';
        previewArea.innerHTML = '';
    }

    // Form submission handler
    document.getElementById('editVillaForm').addEventListener('submit', function(e) {
        // Remove the problematic code that was adding files twice
        // The files are already properly set in the file input, no need to manually add them
        
        // Get selected primary image index if any for new images
        const primaryRadio = document.querySelector('input[name="new_primary_image_index"]:checked');
        if (primaryRadio) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'new_primary_image_index';
            hiddenInput.value = primaryRadio.value;
            this.appendChild(hiddenInput);
        }
    });

    // Kapak fotoğrafı işlemleri
    document.querySelectorAll('input[name="primary_image"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const imageId = this.value;
            const selectedRadio = this;
            
            // Seçilen radio'yu geçici olarak devre dışı bırak
            const allRadios = document.querySelectorAll('input[name="primary_image"]');
            allRadios.forEach(r => r.disabled = true);
            
            // Seçilen resmin container'ını bul
            const selectedCard = selectedRadio.closest('.card');
            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'position-absolute w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75';
            loadingIndicator.style.top = '0';
            loadingIndicator.style.left = '0';
            loadingIndicator.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
            selectedCard.style.position = 'relative';
            selectedCard.appendChild(loadingIndicator);
            
            setPrimaryImage(imageId)
                .then(() => {
                    allRadios.forEach(r => r.disabled = false);
                    selectedCard.removeChild(loadingIndicator);
                    updateStarBadges(imageId);
                })
                .catch((error) => {
                    console.error('Error details:', error);
                    selectedCard.removeChild(loadingIndicator);
                    allRadios.forEach(r => {
                        r.disabled = false;
                        if (r.checked && r !== selectedRadio) {
                            r.checked = true;
                        }
                    });
                    alert('Kapak fotoğrafı güncellenirken bir hata oluştu: ' + error.message);
                });
        });
    });

    function updateStarBadges(selectedImageId) {
        document.querySelectorAll('.position-absolute').forEach(container => {
            if (container.querySelector('.badge-success')) {
                container.remove();
            }
        });
        
        const selectedImageContainer = document.querySelector(`#primary_image_${selectedImageId}`)
            .closest('.card')
            .querySelector('.position-relative');
            
        if (selectedImageContainer) {
            const badgeContainer = document.createElement('div');
            badgeContainer.className = 'position-absolute top-0 start-0 p-1';
            badgeContainer.innerHTML = '<span class="badge badge-success"><i class="fas fa-star"></i></span>';
            selectedImageContainer.appendChild(badgeContainer);
        }
    }

    function setPrimaryImage(imageId) {
        const url = `/admin/villas/{{ $villa->slug }}/images/${imageId}/primary`;

        return fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Kapak fotoğrafı güncellenirken bir hata oluştu.');
            }
            return data;
        });
    }
});
</script> 
@endpush