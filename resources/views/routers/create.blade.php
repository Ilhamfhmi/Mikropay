@extends('layouts.app')

@section('title', 'Tambah Router')
@section('page-title', 'Tambah Router Baru')
@section('page-subtitle', 'Hubungkan Mikrotik baru ke sistem')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i> Form Koneksi Mikrotik</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('routers.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Identitas Router</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Mikrotik Pusat" required>
                        <small class="text-muted">Nama bebas untuk memudahkan Anda mengenali router.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">IP Address / Domain (VPN)</label>
                            <input type="text" name="ip_address" class="form-control" placeholder="192.168.88.1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Port API</label>
                            <input type="number" name="port" class="form-control" value="8728" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Username API</label>
                            <input type="text" name="username" class="form-control" placeholder="admin" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Password API</label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('routers.index') }}" class="btn btn-light text-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Simpan Router
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection