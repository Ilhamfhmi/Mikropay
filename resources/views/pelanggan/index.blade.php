@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Manajemen Pelanggan')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0 fw-bold text-primary">Daftar Pelanggan</h5>
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Pelanggan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>Username PPPoE</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $c->name }}</div>
                            <small class="text-muted">{{ $c->phone }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $c->package->name ?? '-' }}</span><br>
                            <small>Rp {{ number_format($c->package->price ?? 0) }}</small>
                        </td>
                        <td>{{ $c->username_pppoe }}</td>
                        <td>{{ \Carbon\Carbon::parse($c->due_date)->format('d M Y') }}</td>
                        <td>
                            @if($c->status == 'active')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($c->status == 'isolated')
                                <span class="badge bg-danger">Terisolir</span>
                            @else
                                <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('pelanggan.edit', $c->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('pelanggan.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Tagihan mereka juga akan hilang.');">
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
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection