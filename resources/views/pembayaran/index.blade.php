@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')
@section('page-title', 'Riwayat Pembayaran')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <h5 class="fw-bold text-success mb-4"><i class="fas fa-check-double me-2"></i> Data Pembayaran Diterima</h5>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Tgl Bayar</th>
                        <th>No. Invoice</th>
                        <th>Pelanggan</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->paid_at)->format('d/m/Y H:i') }}</td>
                        <td class="fw-bold">{{ $p->inv_number }}</td>
                        <td>{{ $p->customer->name }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($p->amount) }}</td>
                        <td><span class="badge bg-light text-dark border">Manual / Tunai</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-secondary" title="Cetak Struk" onclick="alert('Fitur Cetak segera hadir!')">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection