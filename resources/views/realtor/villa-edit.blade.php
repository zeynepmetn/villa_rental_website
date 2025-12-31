@extends('layouts.realtor')

@section('title', isset($villa) ? 'Villa Düzenle' : 'Yeni Villa Ekle')

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

    .upload-area {
        border: 2px dashed #e3e6f0;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #4e73df;
        background-color: #f8f9fc;
    }

    .upload-zone-active {
        border-color: #4e73df !important;
        background-color: #f8f9fc !important;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.35rem 0.5rem;
    }

    .preview-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 4px;
    }

    .image-preview-card {
        position: relative;
        margin-bottom: 1rem;
    }

    .image-preview-card .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .image-preview-card .remove-image:hover {
        background: #fff;
        transform: scale(1.1);
    }

    .primary-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(40, 167, 69, 0.9);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
    }

    .image-controls {
        padding: 10px;
        background: #f8f9fc;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
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

    .existing-image-card {
        transition: all 0.3s ease;
        border: 1px solid #e3e6f0;
    }

    .existing-image-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .delete-image-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .delete-image-btn:hover {
        transform: scale(1.1);
        background-color: #dc3545 !important;
    }

    .set-primary-btn:checked + label {
        color: #28a745;
        font-weight: 600;
    }

    .badge-primary {
        background-color: #4e73df !important;
    }

    .new-image-section {
        border-top: 2px dashed #e3e6f0;
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }

    /* Ensure right panel stays on the right */
    .col-lg-4 {
        position: relative;
    }

    /* Make image cards more compact */
    .existing-image-card .card-body {
        padding: 0.5rem !important;
    }

    .existing-image-card .form-check-label {
        font-size: 0.75rem;
        line-height: 1.2;
    }

    /* Compact upload area */
    .upload-area {
        min-height: 100px;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .col-lg-4 {
            margin-top: 2rem;
        }
    }

    /* Ensure textareas have minimum height */
    /* Removed conflicting rules - now using inline styles with !important */
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">{{ isset($villa) ? 'Villa Düzenle' : 'Yeni Villa Ekle' }}</h1>
        <a href="{{ route('realtor.villas') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('realtor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('realtor.villas') }}">Villalarım</a></li>
        <li class="breadcrumb-item active">{{ isset($villa) ? 'Villa Düzenle' : 'Yeni Villa Ekle' }}</li>
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

    <form action="{{ isset($villa) ? route('realtor.villas.update', $villa) : route('realtor.villas.store') }}" method="POST" enctype="multipart/form-data" id="villaForm">
        @csrf
        @if(isset($villa))
            @method('PUT')
        @endif
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
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $villa->title ?? '') }}" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label">Açıklama <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5" style="height: 120px !important; min-height: 120px !important;" required>{{ old('description', $villa->description ?? '') }}</textarea>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="location_id" class="form-label">Lokasyon <span class="text-danger">*</span></label>
                                <select class="form-control" id="location_id" name="location_id" required>
                                    <option value="">Seçiniz</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id', $villa->location_id ?? '') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
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
                                    <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $villa->bedrooms ?? '') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="bathrooms" class="form-label">Banyo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bath"></i></span>
                                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $villa->bathrooms ?? '') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="max_guests" class="form-label">Kapasite <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" class="form-control" id="max_guests" name="max_guests" value="{{ old('max_guests', $villa->capacity ?? '') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="area" class="form-label">Büyüklük (m²) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-vector-square"></i></span>
                                    <input type="number" class="form-control" id="area" name="area" value="{{ old('area', $villa->size ?? '') }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="address" class="form-label">Adres <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="5" style="height: 120px !important; min-height: 120px !important;" required>{{ old('address', $villa->address ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="latitude" class="form-label">Enlem</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="number" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $villa->latitude ?? '') }}" step="any">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="longitude" class="form-label">Boylam</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="number" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $villa->longitude ?? '') }}" step="any">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Görseller -->
                @if(!isset($villa))
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Görseller</h6>
                    </div>
                    <div class="card-body">
                        <div class="upload-area mb-4" id="uploadZone">
                            <input type="file" 
                                   name="images[]" 
                                   id="imageInput" 
                                   multiple 
                                   accept="image/*"
                                   style="display: none;">
                            <div class="text-center py-4">
                                <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                <h6 class="mb-2">Görselleri Yükle</h6>
                                <p class="text-muted small mb-2">PNG, JPG veya GIF</p>
                                <button type="button" class="btn btn-sm btn-primary px-4" onclick="document.getElementById('imageInput').click();">
                                    Dosya Seç
                                </button>
                            </div>
                        </div>
                        <div id="imagePreviewContainer" class="row"></div>
                    </div>
                </div>
                @else
                <!-- Mevcut Villa Görselleri -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold gradient-text">Görseller</h6>
                        <span class="badge badge-primary">{{ $villa->images->count() }} Görsel</span>
                    </div>
                    <div class="card-body">
                        <!-- Mevcut Görseller -->
                        @if($villa->images->count() > 0)
                        <div class="mb-3">
                            <h6 class="font-weight-bold mb-3">Mevcut Görseller</h6>
                            <div class="row" id="existingImages">
                                @foreach($villa->images as $index => $image)
                                <div class="col-md-6 col-lg-4 mb-3" id="image-{{ $image->id }}">
                                    <div class="card h-100 existing-image-card">
                                        <div class="position-relative">
                                            <img src="{{ $image->url }}" 
                                                 class="card-img-top"
                                                 alt="Villa görsel {{ $index + 1 }}"
                                                 style="height: 120px; object-fit: cover;"
                                                 onerror="this.src='{{ asset('images/villa-placeholder.jpg') }}'">
                                            @if($image->is_primary)
                                            <div class="position-absolute top-0 start-0 p-1">
                                                <span class="badge bg-success" style="font-size: 0.7rem;">
                                                    <i class="fas fa-star"></i> Ana
                                                </span>
                                            </div>
                                            @endif
                                            <div class="position-absolute top-0 end-0 p-1">
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-image-btn"
                                                        data-image-id="{{ $image->id }}"
                                                        title="Görseli Sil"
                                                        style="width: 25px; height: 25px; font-size: 0.7rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="form-check">
                                                <input class="form-check-input set-primary-btn" 
                                                       type="radio" 
                                                       name="set_primary_image" 
                                                       value="{{ $image->id }}"
                                                       data-image-id="{{ $image->id }}"
                                                       {{ $image->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label small" style="font-size: 0.8rem;">
                                                    Ana görsel yap
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Yeni Görsel Ekleme -->
                        <div class="new-image-section">
                            <h6 class="font-weight-bold mb-3">Yeni Görsel Ekle</h6>
                            <div class="upload-area mb-3" id="uploadZone">
                                <input type="file" 
                                       name="new_images[]" 
                                       id="imageInput" 
                                       multiple 
                                       accept="image/*"
                                       style="display: none;">
                                <div class="text-center py-3">
                                    <i class="fas fa-cloud-upload-alt fa-lg text-primary mb-2"></i>
                                    <h6 class="mb-1" style="font-size: 0.9rem;">Yeni Görselleri Yükle</h6>
                                    <p class="text-muted small mb-2" style="font-size: 0.8rem;">PNG, JPG veya GIF (Max 20MB)</p>
                                    <button type="button" class="btn btn-sm btn-primary px-3" onclick="document.getElementById('imageInput').click();">
                                        <i class="fas fa-plus me-1"></i> Dosya Seç
                                    </button>
                                </div>
                            </div>
                            <div id="newImagePreviewContainer" class="row"></div>
                        </div>
                    </div>
                </div>
                @endif
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
                                <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $villa->price_per_night ?? '') }}" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($villa))
                <!-- Durum -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Durum</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $villa->is_active ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Özellikler -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold gradient-text">Özellikler</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($features as $feature)
                            <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature_{{ $feature->id }}"
                                        @if(isset($selectedFeatures) && in_array($feature->id, $selectedFeatures)) checked @endif>
                                    <label class="form-check-label" for="feature_{{ $feature->id }}">
                                        {{ $feature->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('realtor.villas') }}" class="btn btn-secondary">
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

@section('scripts')
<script>
// More comprehensive warning suppression
(function() {
    const originalWarn = console.warn;
    const originalError = console.error;
    const originalLog = console.log;
    
    console.warn = function(message) {
        if (typeof message === 'string' && 
            (message.includes('cache store does not support tagging') || 
             message.includes('Cache store') ||
             message.includes('tagging'))) {
            return; // Suppress cache-related warnings
        }
        originalWarn.apply(console, arguments);
    };
    
    console.error = function(message) {
        if (typeof message === 'string' && 
            (message.includes('cache store does not support tagging') || 
             message.includes('Cache store') ||
             message.includes('tagging'))) {
            return; // Suppress cache-related errors
        }
        originalError.apply(console, arguments);
    };
    
    console.log = function(message) {
        if (typeof message === 'string' && 
            (message.includes('cache store does not support tagging') || 
             message.includes('Cache store') ||
             message.includes('tagging'))) {
            return; // Suppress cache-related logs
        }
        originalLog.apply(console, arguments);
    };
})();

document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const uploadZone = document.getElementById('uploadZone');
    const form = document.getElementById('villaForm');
    let selectedFiles = [];

    @if(!isset($villa))
    // New villa creation - original functionality
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');

    function createImagePreview(file, index) {
        const reader = new FileReader();
        const col = document.createElement('div');
        col.className = 'col-md-4';
        
        const previewCard = document.createElement('div');
        previewCard.className = 'image-preview-card';
        previewCard.innerHTML = `
            <div class="position-relative">
                <div class="preview-loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                </div>
                <img class="preview-image" src="" alt="Preview">
                <button type="button" class="btn btn-sm btn-danger remove-image" data-index="${index}">
                    <i class="fas fa-times"></i>
                </button>
                ${index === 0 ? '<span class="primary-badge"><i class="fas fa-star"></i> Ana Görsel</span>' : ''}
            </div>
            <div class="image-controls">
                <div class="form-check">
                    <input class="form-check-input primary-selector" type="radio" name="primary_image" 
                           value="${index}" ${index === 0 ? 'checked' : ''}>
                    <label class="form-check-label">Ana görsel yap</label>
                </div>
            </div>
        `;

        reader.onload = function(e) {
            const img = previewCard.querySelector('img');
            img.src = e.target.result;
            previewCard.querySelector('.preview-loading').style.display = 'none';
        };

        reader.readAsDataURL(file);
        col.appendChild(previewCard);
        imagePreviewContainer.appendChild(col);

        // Remove button handler
        previewCard.querySelector('.remove-image').addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            selectedFiles = selectedFiles.filter((_, i) => i !== index);
            updatePreviews();
        });

        // Primary image selector handler
        previewCard.querySelector('.primary-selector').addEventListener('change', function() {
            document.querySelectorAll('.primary-badge').forEach(badge => badge.remove());
            if (this.checked) {
                const newBadge = document.createElement('span');
                newBadge.className = 'primary-badge';
                newBadge.innerHTML = '<i class="fas fa-star"></i> Ana Görsel';
                this.closest('.image-preview-card').querySelector('.position-relative').appendChild(newBadge);
            }
        });
    }

    function updatePreviews() {
        imagePreviewContainer.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            createImagePreview(file, index);
        });
    }

    // Form submission handler for new villa
    form.addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('Lütfen en az bir görsel seçin.');
            return;
        }

        // Create a new FormData instance
        const formData = new FormData(this);
        
        // Remove any existing file inputs
        formData.delete('images[]');
        
        // Add selected files
        selectedFiles.forEach(file => {
            formData.append('images[]', file);
        });

        // Continue with form submission
        this.submit();
    });

    @else
    // Existing villa editing functionality - SIMPLIFIED APPROACH
    const newImagePreviewContainer = document.getElementById('newImagePreviewContainer');

    function createNewImagePreview(file, index) {
        const reader = new FileReader();
        const col = document.createElement('div');
        col.className = 'col-md-4';
        
        const previewCard = document.createElement('div');
        previewCard.className = 'image-preview-card';
        previewCard.innerHTML = `
            <div class="position-relative">
                <div class="preview-loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                </div>
                <img class="preview-image" src="" alt="Preview">
                <button type="button" class="btn btn-sm btn-danger remove-new-image" data-index="${index}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="image-controls">
                <small class="text-muted">Yeni görsel</small>
            </div>
        `;

        reader.onload = function(e) {
            const img = previewCard.querySelector('img');
            img.src = e.target.result;
            previewCard.querySelector('.preview-loading').style.display = 'none';
        };

        reader.readAsDataURL(file);
        col.appendChild(previewCard);
        newImagePreviewContainer.appendChild(col);

        // Remove button handler
        previewCard.querySelector('.remove-new-image').addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            selectedFiles = selectedFiles.filter((_, i) => i !== index);
            updateNewPreviews();
        });
    }

    function updateNewPreviews() {
        newImagePreviewContainer.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            createNewImagePreview(file, index);
        });
        
        // Update the file input with current selected files
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        imageInput.files = dt.files;
    }

    // Delete existing image functionality
    document.querySelectorAll('.delete-image-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            const imageCard = document.getElementById('image-' + imageId);
            
            if (confirm('Bu görseli silmek istediğinizden emin misiniz?')) {
                // Show loading
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;
                
                fetch(`/realtor/villas/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        imageCard.remove();
                        // Update image count badge
                        const badge = document.querySelector('.badge-primary');
                        if (badge) {
                            const currentCount = parseInt(badge.textContent.split(' ')[0]);
                            badge.textContent = `${currentCount - 1} Görsel`;
                        }
                    } else {
                        alert(data.message || 'Görsel silinirken bir hata oluştu.');
                        this.innerHTML = '<i class="fas fa-trash"></i>';
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Görsel silinirken bir hata oluştu.');
                    this.innerHTML = '<i class="fas fa-trash"></i>';
                    this.disabled = false;
                });
            }
        });
    });

    // Set primary image functionality with better error suppression
    document.querySelectorAll('.set-primary-btn').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const imageId = this.getAttribute('data-image-id');
                
                // Show loading on all radios
                document.querySelectorAll('.set-primary-btn').forEach(r => r.disabled = true);
                
                // Suppress any console output during this operation
                const originalConsole = {
                    warn: console.warn,
                    error: console.error,
                    log: console.log
                };
                
                console.warn = function() {};
                console.error = function() {};
                console.log = function() {};
                
                fetch(`/realtor/villas/{{ $villa->slug }}/images/${imageId}/set-primary`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove all primary badges
                        document.querySelectorAll('.badge.bg-success').forEach(badge => badge.remove());
                        
                        // Add primary badge to selected image
                        const selectedImageCard = document.getElementById('image-' + imageId);
                        const imageContainer = selectedImageCard.querySelector('.position-relative');
                        const newBadge = document.createElement('div');
                        newBadge.className = 'position-absolute top-0 start-0 p-1';
                        newBadge.innerHTML = '<span class="badge bg-success" style="font-size: 0.7rem;"><i class="fas fa-star"></i> Ana</span>';
                        imageContainer.appendChild(newBadge);
                        
                        // Show success message without console output
                        // alert('Ana görsel başarıyla ayarlandı.');
                    } else {
                        alert(data.message || 'Ana görsel ayarlanırken bir hata oluştu.');
                    }
                })
                .catch(error => {
                    // Don't log the error to console
                    alert('Ana görsel ayarlanırken bir hata oluştu.');
                })
                .finally(() => {
                    // Restore console functions
                    console.warn = originalConsole.warn;
                    console.error = originalConsole.error;
                    console.log = originalConsole.log;
                    
                    // Re-enable all radios
                    document.querySelectorAll('.set-primary-btn').forEach(r => r.disabled = false);
                });
            }
        });
    });
    @endif

    // Common functionality for both new and existing villas
    function handleFiles(files) {
        const newFiles = Array.from(files);
        selectedFiles = [...selectedFiles, ...newFiles];
        
        // Update the file input with all selected files
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        imageInput.files = dt.files;
        
        @if(!isset($villa))
        updatePreviews();
        @else
        updateNewPreviews();
        @endif
    }

    // File input change handler
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            handleFiles(this.files);
            // Don't reset input value - let handleFiles manage it
        });
    }

    // Drag and drop handlers
    if (uploadZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadZone.classList.add('upload-zone-active');
        }

        function unhighlight(e) {
            uploadZone.classList.remove('upload-zone-active');
        }

        uploadZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        });
    }

    // Form submission handler for existing villa
    @if(isset($villa))
    form.addEventListener('submit', function(e) {
        // Remove the problematic code that was adding files twice
        // The files are already properly set in the file input via handleFiles function
        
        // Just let the form submit normally without manually adding files
        return true;
    });
    @endif
});
</script>
@endsection