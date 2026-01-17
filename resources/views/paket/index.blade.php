@extends('layouts.app')

@section('title', 'Daftar Paket')
@section('page-title', 'Paket Internet')
@section('page-subtitle', 'Kelola harga dan profil paket internet')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-box me-2"></i> List Paket</h5>
                    <a href="{{ route('paket.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Buat Paket Baru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 ps-3 rounded-start">Nama Paket (Web)</th>
                                <th class="py-3">Profile Mikrotik</th>
                                <th class="py-3">Harga</th>
                                <th class="py-3">Router</th>
                                <th class="py-3 text-center rounded-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $package)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $package->name }}</td>
                                <td><span class="badge bg-info text-dark">{{ $package->mikrotik_profile }}</span></td>
                                <td class="fw-bold text-success">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                                <td>{{ $package->router->name ?? 'Router Terhapus' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('paket.edit', $package->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('paket.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
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
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada paket. Silakan buat baru.</td>
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