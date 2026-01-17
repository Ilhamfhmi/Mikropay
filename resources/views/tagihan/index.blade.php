@extends('layouts.app')

@section('title', 'Data Tagihan')
@section('page-title', 'Daftar Tagihan')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0 fw-bold text-primary">Riwayat Tagihan</h5>
            <a href="{{ route('tagihan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Buat Tagihan Manual
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>No. Invoice</th>
                        <th>Periode</th>
                        <th>Pelanggan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    <tr>
                        <td class="fw-bold">{{ $inv->inv_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($inv->period)->format('d M Y') }}</td>
                        <td>
                            {{ $inv->customer->name }} <br>
                            <small class="text-muted">{{ $inv->customer->package->name ?? 'Paket Hapus' }}</small>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($inv->amount) }}</td>
                        <td>
                            @if($inv->status == 'paid')
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i> LUNAS</span><br>
                                <small class="text-muted" style="font-size: 10px">{{ $inv->paid_at }}</small>
                            @else
                                <span class="badge bg-warning text-dark">BELUM BAYAR</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if($inv->status == 'unpaid')
                                    <form action="{{ route('tagihan.pay', $inv->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin konfirmasi pembayaran ini?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" title="Konfirmasi Bayar">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('tagihan.edit', $inv->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Tagihan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-light border" disabled><i class="fas fa-check"></i></button>
                                @endif

                                <form action="{{ route('tagihan.destroy', $inv->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tagihan ini?');">
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
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada tagihan dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection