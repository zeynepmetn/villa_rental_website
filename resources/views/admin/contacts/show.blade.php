@extends('layouts.admin')

@section('title', 'İletişim Mesajı Detayı')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">İletişim Mesajı Detayı</h1>
        <a href="{{ route('admin.contacts') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>

    <div class="row">
        <!-- Message Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Mesaj İçeriği</h6>
                    <div>
                        @if($contact->status == 'new')
                            <span class="badge badge-success">Yeni</span>
                        @elseif($contact->status == 'read')
                            <span class="badge badge-warning">Okunmuş</span>
                        @else
                            <span class="badge badge-primary">Yanıtlanmış</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="message-header mb-4">
                        <h5 class="mb-2">{{ $contact->name }}</h5>
                        <p class="text-muted mb-1">
                            <i class="fas fa-envelope mr-2"></i>{{ $contact->email }}
                        </p>
                        @if($contact->phone)
                        <p class="text-muted mb-1">
                            <i class="fas fa-phone mr-2"></i>{{ $contact->phone }}
                        </p>
                        @endif
                        <p class="text-muted mb-1">
                            <i class="fas fa-tag mr-2"></i>
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
                        </p>
                        <p class="text-muted">
                            <i class="fas fa-clock mr-2"></i>{{ $contact->created_at->format('d.m.Y H:i') }}
                        </p>
                    </div>

                    <hr>

                    <div class="message-content">
                        <h6 class="font-weight-bold mb-3">Mesaj:</h6>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    @if($contact->status === 'replied' && $contact->reply_message)
                    <hr>
                    <div class="reply-content">
                        <h6 class="font-weight-bold mb-3 text-success">
                            <i class="fas fa-reply mr-2"></i>Gönderilen Yanıt:
                        </h6>
                        <div class="bg-success bg-opacity-10 border border-success p-3 rounded">
                            {!! nl2br(e($contact->reply_message)) !!}
                        </div>
                        @if($contact->replied_at)
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-clock mr-1"></i>Yanıtlanma Tarihi: {{ $contact->replied_at->format('d.m.Y H:i') }}
                        </small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            @if($contact->status !== 'replied')
            <!-- Reply Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-reply mr-2"></i>Yanıt Gönder
                    </h6>
                </div>
                <div class="card-body">
                    <form id="replyForm">
                        @csrf
                        <div class="form-group">
                            <label for="reply_message" class="font-weight-bold">Yanıt Mesajı:</label>
                            <textarea class="form-control" id="reply_message" name="reply_message" rows="15" 
                                      style="height: 200px !important; min-height: 200px !important;"
                                      placeholder="Kullanıcıya gönderilecek yanıt mesajınızı buraya yazın..." required></textarea>
                            <small class="form-text text-muted">
                                Bu mesaj kullanıcının e-posta adresine gönderilecektir.
                            </small>
                        </div>
                        
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-2"></i>E-posta Gönder ve Yanıtlandı İşaretle
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="clearReplyForm()">
                                <i class="fas fa-times mr-2"></i>Temizle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <div class="text-success mb-3">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <h5 class="text-success">Bu mesaj yanıtlanmış</h5>
                    <p class="text-muted">Bu iletişim mesajına zaten yanıt gönderilmiş ve kullanıcı bilgilendirilmiş.</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">İşlemler</h6>
                </div>
                <div class="card-body">
                    @if($contact->status != 'replied')
                    <button type="button" class="btn btn-success btn-block mb-3" 
                            onclick="markAsReplied({{ $contact->id }})">
                        <i class="fas fa-reply mr-2"></i>Yanıtlandı Olarak İşaretle
                    </button>
                    @endif

                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" 
                       class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-envelope mr-2"></i>E-posta Gönder
                    </a>

                    @if($contact->phone)
                    <a href="tel:{{ $contact->phone }}" class="btn btn-info btn-block mb-3">
                        <i class="fas fa-phone mr-2"></i>Ara
                    </a>
                    @endif

                    <button type="button" class="btn btn-danger btn-block" 
                            onclick="deleteContact({{ $contact->id }})">
                        <i class="fas fa-trash mr-2"></i>Mesajı Sil
                    </button>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">İletişim Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="info-item mb-3">
                            <strong>Ad Soyad:</strong><br>
                            {{ $contact->name }}
                        </div>
                        
                        <div class="info-item mb-3">
                            <strong>E-posta:</strong><br>
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                        
                        @if($contact->phone)
                        <div class="info-item mb-3">
                            <strong>Telefon:</strong><br>
                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                        </div>
                        @endif
                        
                        <div class="info-item mb-3">
                            <strong>Mesaj Tarihi:</strong><br>
                            {{ $contact->created_at->format('d.m.Y H:i') }}
                        </div>
                        
                        @if($contact->read_at)
                        <div class="info-item mb-3">
                            <strong>Okunma Tarihi:</strong><br>
                            {{ $contact->read_at->format('d.m.Y H:i') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Reply form submission
const replyForm = document.getElementById('replyForm');
if (replyForm) {
    replyForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const replyMessage = document.getElementById('reply_message').value.trim();
        
        if (replyMessage.length < 10) {
            alert('Yanıt mesajı en az 10 karakter olmalıdır.');
            return;
        }
        
        if (confirm('Bu yanıtı kullanıcıya e-posta olarak göndermek istediğinizden emin misiniz?')) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Gönderiliyor...';
            
            fetch(`/admin/contacts/{{ $contact->id }}/reply`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reply_message: replyMessage
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('E-posta başarıyla gönderildi!');
                    location.reload();
                } else {
                    alert('Bir hata oluştu: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            })
            .finally(() => {
                // Restore button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        }
    });
}

function clearReplyForm() {
    const replyMessageField = document.getElementById('reply_message');
    if (replyMessageField) {
        replyMessageField.value = '';
    }
}

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
                window.location.href = '{{ route("admin.contacts") }}';
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