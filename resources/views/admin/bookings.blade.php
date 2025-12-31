@extends('layouts.admin')

@section('title', 'Rezervasyonlar')

@section('styles')
<style>
    .dataTables_length select {
        width: 80px !important;
        height: 42px !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Rezervasyonlar</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Rezervasyonlar</li>
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
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filtreler
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bookings') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Durum</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Tümü</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Bekleyen</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Onaylı</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Giriş Tarihi (Başlangıç)</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Çıkış Tarihi (Bitiş)</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label">Arama</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Villa, müşteri, ID..." value="{{ request('search') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrele
                    </button>
                    <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Temizle
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar me-1"></i>
            Tüm Rezervasyonlar ({{ $bookings->count() }} adet)
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="bookingsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Villa</th>
                            <th>Müşteri</th>
                            <th>Giriş Tarihi</th>
                            <th>Çıkış Tarihi</th>
                            <th>Toplam Fiyat</th>
                            <th>Durum</th>
                            <th>Oluşturulma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>
                                    <a href="{{ route('villas.show', $booking->villa) }}" target="_blank">
                                        {{ $booking->villa->title }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $booking->villa->location->name }}</small>
                                </td>
                                <td>
                                    {{ $booking->customer->name }}
                                    <br>
                                    <small class="text-muted">{{ $booking->customer->email }}</small>
                                </td>
                                <td data-order="{{ $booking->check_in->format('Y-m-d') }}">
                                    {{ $booking->check_in->format('d.m.Y') }}
                                </td>
                                <td data-order="{{ $booking->check_out->format('Y-m-d') }}">
                                    {{ $booking->check_out->format('d.m.Y') }}
                                </td>
                                <td data-order="{{ $booking->total_price }}">
                                    {{ number_format($booking->total_price, 2) }} ₺
                                </td>
                                <td>
                                    @if($booking->status == 'pending')
                                        <span class="badge bg-warning">Bekleyen</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="badge bg-success">Onaylı</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge bg-primary">Tamamlandı</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="badge bg-danger">İptal</span>
                                    @endif
                                </td>
                                <td data-order="{{ $booking->created_at->format('Y-m-d H:i:s') }}">
                                    {{ $booking->created_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#bookingsTable').DataTable({
            order: [[7, 'desc']], // Sort by created_at by default (newest first)
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
            lengthChange: true,
            searching: true,
            info: true,
            paging: true,
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
            },
            columnDefs: [
                {
                    targets: [3, 4, 7], // Date columns (check_in, check_out, created_at)
                    type: 'date'
                },
                {
                    targets: [5], // Price column
                    type: 'num'
                }
            ]
        });
    });
</script>
@endpush

@section('styles')
<style>
    .dataTables_length select {
        height: calc(2.5em + 0.75rem + 2px) !important;
        padding: 0.5rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0.35rem;
    }

    .dataTables_filter input {
        height: calc(2.5em + 0.75rem + 2px) !important;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0.35rem;
    }

    .table th {
        font-weight: 600;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        padding: 0.5em 0.75em;
    }

    .gradient-text {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-header {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        color: white;
        font-weight: 600;
    }
</style>
@endsection 