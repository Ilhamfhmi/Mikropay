@extends('layouts.app')

@section('title', 'Data Router')
@section('page-title', 'Manajemen Router')
@section('page-subtitle', 'Daftar Mikrotik yang terhubung ke sistem')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-server me-2"></i> List Router Mikrotik</h5>
                    <a href="{{ route('routers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Router
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 ps-3 rounded-start">Nama Router</th>
                                <th class="py-3">IP Address</th>
                                <th class="py-3">Username API</th>
                                <th class="py-3">Port</th>
                                <th class="py-3 text-center rounded-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($routers as $router)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $router->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $router->ip_address }}
                                    </span>
                                </td>
                                <td>{{ $router->username }}</td>
                                <td>{{ $router->port }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        
                                        <a href="{{ route('routers.test', $router->id) }}" class="btn btn-sm btn-outline-info" title="Cek Koneksi">
                                            <i class="fas fa-network-wired"></i>
                                        </a>

                                        <a href="{{ route('routers.edit', $router->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('routers.destroy', $router->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Router ini? Data paket & pelanggan terkait akan ikut terhapus!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="80" class="mb-3 opacity-50" alt="empty">
                                    <p class="mb-0">Belum ada router yang ditambahkan.</p>
                                    <small>Klik tombol Tambah Router untuk memulai.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection