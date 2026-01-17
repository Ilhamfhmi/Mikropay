@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Data Pelanggan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('pelanggan.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">1. Data Pribadi</h6>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. WhatsApp</label>
                                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Pemasangan</label>
                                <textarea name="address" class="form-control" rows="2">{{ $customer->address }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Langganan</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="isolated" {{ $customer->status == 'isolated' ? 'selected' : '' }}>Terisolir (Suspend)</option>
                                    <option value="non-active" {{ $customer->status == 'non-active' ? 'selected' : '' }}>Non-Aktif (Berhenti)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">2. Paket & Akun Internet</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Pilih Router</label>
                                <select name="router_id" class="form-select" required>
                                    @foreach($routers as $r)
                                        <option value="{{ $r->id }}" {{ $customer->router_id == $r->id ? 'selected' : '' }}>
                                            {{ $r->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Paket</label>
                                <select name="package_id" class="form-select" required>
                                    @foreach($packages as $p)
                                        <option value="{{ $p->id }}" {{ $customer->package_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} - Rp {{ number_format($p->price) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username PPPoE</label>
                                    <input type="text" name="username_pppoe" class="form-control" value="{{ $customer->username_pppoe }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password PPPoE</label>
                                    <input type="text" name="password_pppoe" class="form-control" value="{{ $customer->password_pppoe }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-danger fw-bold">Tanggal Jatuh Tempo</label>
                                <input type="date" name="due_date" class="form-control" value="{{ $customer->due_date }}" required>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">Update Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection