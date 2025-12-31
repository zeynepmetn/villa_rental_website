@extends('layouts.customer')

@section('title', 'Yorumlarım')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Yorumlarım</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Yorumlarım</li>
        </ol>
    </nav>

    @if(session('info'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star me-2"></i>
                        Tamamlanan Rezervasyonlarım ({{ $completedBookings->count() }} adet)
                    </h6>
                </div>
                <div class="card-body">
                    @if($completedBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Villa</th>
                                        <th>Rezervasyon Tarihi</th>
                                        <th>Konaklama Tarihi</th>
                                        <th>Tutar</th>
                                        <th>Yorum Durumu</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedBookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $booking->villa->main_image }}" 
                                                         alt="{{ $booking->villa->title }}" 
                                                         class="rounded me-3" 
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $booking->villa->title }}</h6>
                                                        <small class="text-muted">{{ $booking->villa->location->name }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                {{ $booking->check_in->format('d.m.Y') }} - 
                                                {{ $booking->check_out->format('d.m.Y') }}
                                                <br>
                                                <small class="text-muted">({{ $booking->nights }} gece)</small>
                                            </td>
                                            <td>{{ number_format($booking->total_price, 2) }} ₺</td>
                                            <td>
                                                @if($booking->hasReview())
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            {!! $booking->review->star_rating !!}
                                                        </div>
                                                        @if($booking->review->is_approved)
                                                            <span class="badge bg-success">Yayında</span>
                                                        @else
                                                            <span class="badge bg-warning">Onay Bekliyor</span>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">
                                                        {{ Str::limit($booking->review->comment, 50) }}
                                                    </small>
                                                @else
                                                    <span class="badge bg-secondary">Yorum Yok</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->hasReview())
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('customer.reviews.edit', $booking->review) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i> Düzenle
                                                        </a>
                                                        <form action="{{ route('customer.reviews.destroy', $booking->review) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Bu yorumu silmek istediğinizden emin misiniz?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i> Sil
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <a href="{{ route('customer.reviews.create', $booking) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-plus"></i> Yorum Yap
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Henüz tamamlanmış rezervasyonunuz bulunmuyor</h5>
                            <p class="text-muted">Konaklama deneyiminiz tamamlandıktan sonra buradan yorum yapabilirsiniz.</p>
                            <a href="{{ route('villas.index') }}" class="btn btn-primary">
                                <i class="fas fa-search"></i> Villa Ara
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .star-rating {
        color: #ffc107;
    }
    
    .btn-group .btn {
        margin-right: 0;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endpush 