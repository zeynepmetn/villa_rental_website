@extends('layouts.admin')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kullanıcı Yönetimi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kullanıcı Yönetimi</li>
    </ol>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-gradient shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50 mr-1"></i> Yeni Kullanıcı Ekle
        </a>
    </div>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold gradient-text">Tüm Kullanıcılar</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filtrele:</div>
                    <a class="dropdown-item" href="{{ route('admin.users') }}">Tümü</a>
                    <a class="dropdown-item" href="{{ route('admin.users', ['role' => 'admin']) }}">Yöneticiler</a>
                    <a class="dropdown-item" href="{{ route('admin.users', ['role' => 'realtor']) }}">Emlakçılar</a>
                    <a class="dropdown-item" href="{{ route('admin.users', ['role' => 'customer']) }}">Müşteriler</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>İsim</th>
                            <th>E-posta</th>
                            <th>Telefon</th>
                            <th>Rol</th>
                            <th>Kayıt Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'Belirtilmemiş' }}</td>
                            <td>
                                @if($user->hasRole('admin'))
                                    <span class="badge badge-primary">Admin</span>
                                @elseif($user->hasRole('realtor'))
                                    <span class="badge badge-info">Emlakçı</span>
                                @elseif($user->hasRole('customer'))
                                    <span class="badge badge-success">Müşteri</span>
                                @else
                                    <span class="badge badge-secondary">Belirsiz</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($user->id != auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
