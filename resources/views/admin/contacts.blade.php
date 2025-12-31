@extends('layouts.admin')

@section('title', 'İletişim Mesajları')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">İletişim Mesajları</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Toplam Mesaj
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Yeni Mesajlar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['new'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Okunmuş
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['read'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Yanıtlanmış
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['replied'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-reply fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtreler</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contacts') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Durum</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Tümü</option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Yeni</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Okunmuş</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Yanıtlanmış</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="subject">Konu</label>
                            <select class="form-control" id="subject" name="subject">
                                <option value="">Tümü</option>
                                <option value="villa-kiralama" {{ request('subject') == 'villa-kiralama' ? 'selected' : '' }}>Villa Kiralama</option>
                                <option value="rezervasyon" {{ request('subject') == 'rezervasyon' ? 'selected' : '' }}>Rezervasyon</option>
                                <option value="iptal-degisiklik" {{ request('subject') == 'iptal-degisiklik' ? 'selected' : '' }}>İptal/Değişiklik</option>
                                <option value="sikayet" {{ request('subject') == 'sikayet' ? 'selected' : '' }}>Şikayet</option>
                                <option value="oneri" {{ request('subject') == 'oneri' ? 'selected' : '' }}>Öneri</option>
                                <option value="diger" {{ request('subject') == 'diger' ? 'selected' : '' }}>Diğer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Arama</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Ad, e-posta veya mesaj içeriği...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Filtrele
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">İletişim Mesajları</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="contactsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>E-posta</th>
                            <th>Telefon</th>
                            <th>Konu</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone ?? '-' }}</td>
                            <td>
                                @switch($contact->subject)
                                    @case('villa-kiralama')
                                        Villa Kiralama
                                        @break
                                    @case('rezervasyon')
                                        Rezervasyon
                                        @break
                                    @case('iptal-degisiklik')
                                        İptal/Değişiklik
                                        @break
                                    @case('sikayet')
                                        Şikayet
                                        @break
                                    @case('oneri')
                                        Öneri
                                        @break
                                    @default
                                        Diğer
                                @endswitch
                            </td>
                            <td>
                                @if($contact->status == 'new')
                                    <span class="badge badge-success">Yeni</span>
                                @elseif($contact->status == 'read')
                                    <span class="badge badge-warning">Okunmuş</span>
                                @else
                                    <span class="badge badge-primary">Yanıtlanmış</span>
                                @endif
                            </td>
                            <td>{{ $contact->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="btn btn-info btn-sm" title="Görüntüle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($contact->status != 'replied')
                                    <button type="button" class="btn btn-success btn-sm" 
                                            onclick="markAsReplied({{ $contact->id }})" title="Yanıtlandı olarak işaretle">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    @endif
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deleteContact({{ $contact->id }})" title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Henüz iletişim mesajı bulunmuyor.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $contacts->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#contactsTable').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [7] }
        ]
    });
});

function markAsReplied(contactId) {
    if (confirm('Bu mesajı yanıtlandı olarak işaretlemek istediğinizden emin misiniz?')) {
        fetch(`/admin/contacts/${contactId}/replied`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
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

function deleteContact(contactId) {
    if (confirm('Bu iletişim mesajını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')) {
        fetch(`/admin/contacts/${contactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
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
</script>
@endpush 