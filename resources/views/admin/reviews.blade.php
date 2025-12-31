@extends('layouts.admin')

@section('title', 'Yorumlar')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Yorumlar</h1>
</div>

<!-- Filters -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filtreler</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reviews') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Durum</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Tümü</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Onay Bekleyen</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Onaylanmış</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="rating" class="form-label">Puan</label>
                <select name="rating" id="rating" class="form-select">
                    <option value="">Tümü</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Yıldız</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Yıldız</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Yıldız</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Yıldız</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Yıldız</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Arama</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Yorum, müşteri adı veya villa adı..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Filtrele
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Reviews Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Yorumlar 
            <span class="badge bg-secondary ms-2">{{ $reviews->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($reviews->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="reviewsTable">
                    <thead>
                        <tr>
                            <th>Müşteri</th>
                            <th>Villa</th>
                            <th>Puan</th>
                            <th>Yorum</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr id="review-{{ $review->id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=667eea&color=fff&size=40" 
                                         alt="{{ $review->user->name }}" 
                                         class="rounded-circle me-2" 
                                         style="width: 40px; height: 40px;">
                                    <div>
                                        <div class="fw-bold">{{ $review->user->name }}</div>
                                        <small class="text-muted">{{ $review->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('villas.show', $review->villa->slug) }}" 
                                   target="_blank" 
                                   class="text-decoration-none">
                                    {{ $review->villa->title }}
                                    <i class="fas fa-external-link-alt ms-1 text-muted"></i>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {!! $review->star_rating !!}
                                    <span class="ms-2 fw-bold">{{ $review->rating }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="max-width: 300px;">
                                    {{ Str::limit($review->comment, 100) }}
                                    @if(strlen($review->comment) > 100)
                                        <button class="btn btn-link btn-sm p-0 ms-1" 
                                                onclick="showFullComment('{{ $review->id }}', '{{ addslashes($review->comment) }}')">
                                            Devamını Oku
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Onaylanmış
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Onay Bekliyor
                                    </span>
                                @endif
                            </td>
                            <td data-order="{{ $review->created_at->timestamp }}">
                                {{ $review->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(!$review->is_approved)
                                        <button class="btn btn-success btn-sm" 
                                                onclick="approveReview({{ $review->id }})"
                                                title="Onayla">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-warning btn-sm" 
                                                onclick="rejectReview({{ $review->id }})"
                                                title="Onayı Kaldır">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-danger btn-sm" 
                                            onclick="deleteReview({{ $review->id }})"
                                            title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Full Comment Modal -->
            <div class="modal fade" id="commentModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tam Yorum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p id="fullCommentText"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Henüz yorum bulunmuyor</h5>
                <p class="text-muted">Müşteriler villa deneyimlerini paylaştığında burada görünecek.</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Destroy any existing DataTable instance
    if ($.fn.DataTable.isDataTable('#reviewsTable')) {
        $('#reviewsTable').DataTable().destroy();
    }
    
    // Initialize with our specific settings
    $('#reviewsTable').DataTable({
        responsive: true,
        order: [[5, 'desc']], // Sort by date column
        columnDefs: [
            { targets: [6], orderable: false, searchable: false }, // Actions column
            { targets: [3], orderable: false }, // Comment column
        ],
        language: {
            "sDecimal": ",",
            "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
            "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoEmpty": "Kayıt yok",
            "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing": "İşleniyor...",
            "sSearch": "Ara:",
            "sSearchPlaceholder": "Arama yapın...",
            "sThousands": ".",
            "sUrl": "",
            "sZeroRecords": "Eşleşen kayıt bulunamadı",
            "oPaginate": {
                "sFirst": "İlk",
                "sLast": "Son",
                "sNext": "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending": ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },
            "select": {
                "rows": {
                    "_": "%d kayıt seçildi",
                    "0": "",
                    "1": "1 kayıt seçildi"
                }
            }
        },
        pageLength: 10,
        lengthChange: false, // Hide the "Show X entries" dropdown
        paging: true,
        info: true,
        searching: true,
        // Override global dom setting to prevent duplicate info
        dom: '<"row"<"col-sm-12 col-md-6"><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });
});

function showFullComment(reviewId, comment) {
    document.getElementById('fullCommentText').textContent = comment;
    new bootstrap.Modal(document.getElementById('commentModal')).show();
}

function approveReview(reviewId) {
    console.log('approveReview called with ID:', reviewId);
    if (confirm('Bu yorumu onaylamak istediğinizden emin misiniz?')) {
        const url = '{{ route("admin.reviews.approve", ":id") }}'.replace(':id', reviewId);
        console.log('Request URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Bir hata oluştu: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu.');
        });
    }
}

function rejectReview(reviewId) {
    console.log('rejectReview called with ID:', reviewId);
    if (confirm('Bu yorumun onayını kaldırmak istediğinizden emin misiniz?')) {
        const url = '{{ route("admin.reviews.reject", ":id") }}'.replace(':id', reviewId);
        console.log('Request URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Bir hata oluştu: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu.');
        });
    }
}

function deleteReview(reviewId) {
    console.log('deleteReview called with ID:', reviewId);
    if (confirm('Bu yorumu kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')) {
        const url = '{{ route("admin.reviews.delete", ":id") }}'.replace(':id', reviewId);
        console.log('Request URL:', url);
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                document.getElementById(`review-${reviewId}`).remove();
                // Update table if using DataTables
                if ($.fn.DataTable.isDataTable('#reviewsTable')) {
                    $('#reviewsTable').DataTable().row(`#review-${reviewId}`).remove().draw();
                }
            } else {
                alert('Bir hata oluştu: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu.');
        });
    }
}
</script>
@endpush 