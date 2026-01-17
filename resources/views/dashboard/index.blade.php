@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan sistem MikroPay')

@section('content')
<div class="container-fluid px-0">
    <!-- Welcome Message -->
    <div class="dashboard-welcome-alert alert mb-4 fade-in-up" style="animation-delay: 0.1s">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-info-circle fa-2x"></i>
            </div>
            <div>
                <h5 class="mb-1">Selamat datang di MikroPay Admin!</h5>
                <p class="mb-0">Sistem ini membantu Anda mengelola pelanggan, tagihan, dan pembayaran dengan mudah.</p>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-4">
        <!-- Total Pelanggan -->
        <div class="col-xl-3 col-lg-6 dashboard-grid-item fade-in-up" style="animation-delay: 0.1s">
            <div class="dashboard-stat-card">
                <div class="d-flex align-items-start">
                    <div class="dashboard-stat-icon dashboard-stat-icon-primary me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="dashboard-stat-title">Total Pelanggan</div>
                        <div class="dashboard-stat-number" style="color: var(--primary-color)">{{ number_format($totalPelanggan) }}</div>
                        <div class="d-flex align-items-center mt-3">
                            <span class="badge bg-success-opacity-10 text-success me-2 border border-success-opacity-25">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ number_format($pelangganAktif) }} Aktif
                            </span>
                            <small class="text-muted">
                                +{{ number_format($pelangganBaruHariIni) }} hari ini
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelanggan Aktif -->
        <div class="col-xl-3 col-lg-6 dashboard-grid-item fade-in-up" style="animation-delay: 0.2s">
            <div class="dashboard-stat-card">
                <div class="d-flex align-items-start">
                    <div class="dashboard-stat-icon dashboard-stat-icon-success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="dashboard-stat-title">Pelanggan Aktif</div>
                        <div class="dashboard-stat-number" style="color: var(--success-color)">{{ number_format($pelangganAktif) }}</div>
                        <div class="mt-3">
                            @if($totalPelanggan > 0)
                                <div class="dashboard-progress mb-2">
                                    <div class="progress-bar bg-success" 
                                         style="width: {{ ($pelangganAktif / $totalPelanggan) * 100 }}%">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ number_format(($pelangganAktif / $totalPelanggan) * 100, 1) }}% dari total
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tagihan Pending -->
        <div class="col-xl-3 col-lg-6 dashboard-grid-item fade-in-up" style="animation-delay: 0.3s">
            <div class="dashboard-stat-card">
                <div class="d-flex align-items-start">
                    <div class="dashboard-stat-icon dashboard-stat-icon-warning me-3">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="dashboard-stat-title">Tagihan Belum Bayar</div>
                        <div class="dashboard-stat-number" style="color: var(--warning-color)">{{ number_format($tagihanPending) }}</div>
                        <div class="mt-3">
                            <span class="badge bg-danger-opacity-10 text-danger me-2 mb-1 border border-danger-opacity-25">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ number_format($tagihanOverdue) }} Jatuh Tempo
                            </span>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ number_format($tagihanBulanIni) }} bulan ini
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tunggakan -->
        <div class="col-xl-3 col-lg-6 dashboard-grid-item fade-in-up" style="animation-delay: 0.4s">
            <div class="dashboard-stat-card">
                <div class="d-flex align-items-start">
                    <div class="dashboard-stat-icon dashboard-stat-icon-danger me-3">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="dashboard-stat-title">Total Tunggakan</div>
                        <div class="dashboard-stat-number" style="color: var(--danger-color)">
                            Rp {{ number_format($uangPending, 0, ',', '.') }}
                        </div>
                        <div class="mt-3">
                            <small class="text-muted d-block">
                                Total pendapatan: 
                                <span class="text-success fw-medium">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </span>
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                Pendapatan bulan ini: 
                                <span class="text-success">
                                    Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                                </span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Recent Data & Stats -->
    <div class="row g-4 mb-4">
        <!-- Pelanggan Terbaru -->
        <div class="col-xl-8">
            <div class="dashboard-card h-100 slide-in-left" style="animation-delay: 0.5s">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0" style="color: var(--primary-color)">
                            <i class="fas fa-history me-2"></i>
                            Pelanggan Terbaru
                        </h5>
                        <p class="text-muted mb-0">8 pelanggan terakhir yang terdaftar</p>
                    </div>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dashboard-table table-hover table-hover-custom">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Paket</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCustomers as $customer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary-opacity-10 me-3" style="color: var(--primary-color)">
                                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-medium">{{ $customer->name }}</h6>
                                                <small class="text-muted">ID: {{ $customer->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <small class="d-block">
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                {{ $customer->phone }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($customer->package)
                                            <span class="badge bg-primary-opacity-10 border border-primary-opacity-25" style="color: var(--primary-color)">
                                                {{ $customer->package->name }}
                                            </span>
                                            <small class="d-block text-muted">
                                                Rp {{ number_format($customer->package->price ?? 0, 0, ',', '.') }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($customer->status == 'active')
                                            <span class="dashboard-status-badge bg-success-opacity-10 border border-success-opacity-25" style="color: var(--success-color)">
                                                <i class="fas fa-circle me-1"></i>
                                                Aktif
                                            </span>
                                        @elseif($customer->status == 'isolated')
                                            <span class="dashboard-status-badge bg-danger-opacity-10 border border-danger-opacity-25" style="color: var(--danger-color)">
                                                <i class="fas fa-ban me-1"></i>
                                                Terisolir
                                            </span>
                                        @elseif($customer->status == 'inactive')
                                            <span class="dashboard-status-badge bg-warning-opacity-10 border border-warning-opacity-25" style="color: var(--warning-color)">
                                                <i class="fas fa-clock me-1"></i>
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('pelanggan.show', $customer->id) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Detail"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="https://wa.me/{{ $customer->phone }}" 
                                               target="_blank" 
                                               class="btn btn-outline-success" 
                                               title="WhatsApp"
                                               data-bs-toggle="tooltip">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-user-slash fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">Belum ada data pelanggan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info & Actions -->
        <div class="col-xl-4">
            <!-- Info Sistem -->
            <div class="dashboard-card mb-4 slide-in-left" style="animation-delay: 0.6s">
                <div class="card-header">
                    <h6 class="card-title mb-0" style="color: var(--primary-color)">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="dashboard-list-group list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Paket</span>
                            <span class="fw-medium">
                                {{ \App\Models\Package::count() }} Paket
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Pendapatan Bulan Ini</span>
                            <span class="fw-medium text-success">
                                Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Tagihan Lunas</span>
                            <span class="fw-medium">
                                {{ number_format($tagihanPaid) }} Invoice
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Pelanggan Non-Aktif</span>
                            <span class="fw-medium text-warning">
                                {{ number_format($pelangganNonAktif) }}
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Pelanggan Terisolir</span>
                            <span class="fw-medium text-danger">
                                {{ number_format($pelangganTerisolir) }}
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Router</span>
                            <span class="fw-medium">
                                {{ number_format($totalRouter) }} Unit
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Akses Cepat -->
            <div class="dashboard-card slide-in-left" style="animation-delay: 0.7s">
                <div class="card-header">
                    <h6 class="card-title mb-0" style="color: var(--primary-color)">
                        <i class="fas fa-bolt me-2"></i>
                        Akses Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('pelanggan.create') }}" 
                               class="btn btn-primary w-100 mb-2 quick-action-btn">
                                <i class="fas fa-user-plus"></i>
                                <span>Tambah Pelanggan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('tagihan.create') }}" 
                               class="btn btn-success w-100 mb-2 quick-action-btn">
                                <i class="fas fa-file-invoice"></i>
                                <span>Buat Tagihan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('pembayaran.create') }}" 
                               class="btn btn-warning w-100 mb-2 quick-action-btn">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Input Pembayaran</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('laporan.index') }}" 
                               class="btn btn-info w-100 mb-2 quick-action-btn" style="background-color: var(--info-color); border-color: var(--info-color)">
                                <i class="fas fa-chart-bar"></i>
                                <span>Lihat Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Additional Stats & Charts -->
    <div class="row g-4">
        <!-- Quick Stats -->
        <div class="col-xl-6">
            <div class="dashboard-card fade-in-up" style="animation-delay: 0.8s">
                <div class="card-header">
                    <h6 class="card-title mb-0" style="color: var(--primary-color)">
                        <i class="fas fa-chart-line me-2"></i>
                        Statistik Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 col-6 border-end">
                            <div class="p-3">
                                <div class="text-muted mb-1">Hari Ini</div>
                                <h5 class="text-primary">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h5>
                                <small class="text-muted">{{ $pembayaranHariIni }} Pembayaran</small>
                            </div>
                        </div>
                        <div class="col-md-4 col-6 border-end">
                            <div class="p-3">
                                <div class="text-muted mb-1">Minggu Ini</div>
                                <h5 class="text-success">Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}</h5>
                                <small class="text-muted">{{ $pelangganBaruMingguIni }} Pelanggan Baru</small>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="p-3">
                                <div class="text-muted mb-1">Bulan Ini</div>
                                <h5 class="text-info">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h5>
                                <small class="text-muted">{{ $pelangganBaruBulanIni }} Pelanggan Baru</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jatuh Tempo Alert -->
        <div class="col-xl-6">
            <div class="dashboard-card fade-in-up" style="animation-delay: 0.9s">
                <div class="card-header">
                    <h6 class="card-title mb-0" style="color: var(--primary-color)">
                        <i class="fas fa-clock me-2"></i>
                        Peringatan Jatuh Tempo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="p-3">
                                <div class="text-muted mb-1">Pelanggan Jatuh Tempo</div>
                                <h4 class="text-danger">{{ number_format($pelangganJatuhTempo) }}</h4>
                                <small class="text-muted">Sudah lewat batas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3">
                                <div class="text-muted mb-1">Akan Jatuh Tempo</div>
                                <h4 class="text-warning">{{ number_format($pelangganJatuhTempoBesok) }}</h4>
                                <small class="text-muted">Besok</small>
                            </div>
                        </div>
                    </div>
                    @if($pelangganJatuhTempo > 0)
                    <div class="alert alert-warning mt-3 mb-0 py-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Ada {{ $pelangganJatuhTempo }} pelanggan yang sudah jatuh tempo. Segera lakukan tindakan!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Recent Payments & Invoices -->
    <div class="row g-4 mt-4">
        <!-- Recent Payments -->
        <div class="col-xl-6">
            <div class="dashboard-card h-100 fade-in-up" style="animation-delay: 1.0s">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0" style="color: var(--primary-color)">
                            <i class="fas fa-money-check-alt me-2"></i>
                            Pembayaran Terbaru
                        </h6>
                        <p class="text-muted mb-0">5 pembayaran terakhir</p>
                    </div>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentPayments) && $recentPayments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentPayments as $payment)
                        <div class="list-group-item border-0 px-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $payment->customer->name ?? 'Pelanggan' }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $payment->payment_date->format('d/m/Y') }}
                                        • {{ $payment->payment_method }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-1 text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</h6>
                                    <span class="badge bg-success-opacity-10 text-success border border-success-opacity-25">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Sukses
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-money-bill-wave fa-3x text-muted opacity-25 mb-3"></i>
                        <p class="text-muted mb-0">Belum ada data pembayaran</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="col-xl-6">
            <div class="dashboard-card h-100 fade-in-up" style="animation-delay: 1.1s">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0" style="color: var(--primary-color)">
                            <i class="fas fa-file-invoice me-2"></i>
                            Tagihan Terbaru
                        </h6>
                        <p class="text-muted mb-0">5 tagihan terakhir</p>
                    </div>
                    <a href="{{ route('tagihan.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentInvoices) && $recentInvoices->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentInvoices as $invoice)
                        <div class="list-group-item border-0 px-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $invoice->customer->name ?? 'Pelanggan' }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-hashtag me-1"></i>
                                        {{ $invoice->inv_number ?? 'INV-' . $invoice->id }}
                                        • {{ $invoice->period->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-1">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</h6>
                                    @if($invoice->status == 'paid')
                                    <span class="badge bg-success-opacity-10 text-success border border-success-opacity-25">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Lunas
                                    </span>
                                    @else
                                    <span class="badge bg-warning-opacity-10 text-warning border border-warning-opacity-25">
                                        <i class="fas fa-clock me-1"></i>
                                        Belum Bayar
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-invoice-dollar fa-3x text-muted opacity-25 mb-3"></i>
                        <p class="text-muted mb-0">Belum ada data tagihan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Add hover effects to dashboard stat cards
    const statCards = document.querySelectorAll('.dashboard-stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add hover effects to quick action buttons
    const quickActionBtns = document.querySelectorAll('.quick-action-btn');
    quickActionBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Auto refresh notification
    let lastRefresh = new Date();
    
    function updateRefreshTime() {
        const now = new Date();
        const diff = Math.floor((now - lastRefresh) / 1000);
        
        if (diff > 300) { // 5 minutes
            console.log('Saran: refresh dashboard untuk data terbaru');
        }
    }
    
    // Update every minute
    setInterval(updateRefreshTime, 60000);
});
</script>
@endpush
@endsection