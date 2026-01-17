@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Analisis & Laporan')

@section('content')

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="opacity-75">Pemasukan Bulan Ini</h6>
                <h2 class="fw-bold mb-0">Rp {{ number_format($pemasukanBulanIni) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="opacity-75">Total Pemasukan (Tahun Ini)</h6>
                <h2 class="fw-bold mb-0">Rp {{ number_format($totalPemasukan) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="opacity-75">Total Tunggakan (Unpaid)</h6>
                <h2 class="fw-bold mb-0">Rp {{ number_format($totalTunggakan) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2"></i> Grafik Pemasukan {{ date('Y') }}</h6>
            </div>
            <div class="card-body">
                <canvas id="incomeChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2"></i> Status Tagihan</h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold">10 Transaksi Terakhir</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td class="ps-4">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $t->inv_number }}</td>
                        <td>{{ $t->customer->name }}</td>
                        <td>Rp {{ number_format($t->amount) }}</td>
                        <td>
                            @if($t->status == 'paid')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Data kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- KONFIGURASI CHART 1: PEMASUKAN BULANAN ---
    const ctxIncome = document.getElementById('incomeChart').getContext('2d');
    new Chart(ctxIncome, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!}, // Ambil label bulan dari Controller
            datasets: [{
                label: 'Pemasukan (Rp)',
                data: {!! json_encode($chartData) !!}, // Ambil data angka dari Controller
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // --- KONFIGURASI CHART 2: STATUS TAGIHAN ---
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Belum Bayar'],
            datasets: [{
                data: [{{ $countPaid }}, {{ $countUnpaid }}], // Ambil data count dari Controller
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)', // Hijau (Lunas)
                    'rgba(255, 206, 86, 0.7)'  // Kuning (Belum)
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection