@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Registrasi Pelanggan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">1. Data Pribadi</h6>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. WhatsApp</label>
                                <input type="text" name="phone" class="form-control" placeholder="628..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Pemasangan</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">2. Paket & Akun Internet</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Pilih Router</label>
                                <select name="router_id" class="form-select" required>
                                    @foreach($routers as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Paket</label>
                                <select name="package_id" class="form-select" required>
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach($packages as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} - Rp {{ number_format($p->price) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username PPPoE</label>
                                    <input type="text" name="username_pppoe" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password PPPoE</label>
                                    <input type="text" name="password_pppoe" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-danger fw-bold">Tanggal Jatuh Tempo</label>
                                <input type="date" name="due_date" class="form-control" required>
                                <small class="text-muted">Tanggal ini akan jadi acuan isolir otomatis.</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection