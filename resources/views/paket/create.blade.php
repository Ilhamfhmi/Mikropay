@extends('layouts.app')

@section('title', 'Buat Paket')
@section('page-title', 'Buat Paket Baru')
@section('page-subtitle', 'Setting harga dan sinkron profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('paket.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Router</label>
                        <select name="router_id" class="form-select" required>
                            <option value="">-- Pilih Router --</option>
                            @foreach($routers as $router)
                                <option value="{{ $router->id }}">{{ $router->name }} ({{ $router->ip_address }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Paket (Tampilan Web)</label>
                            <input type="text" name="name" class="form-control" placeholder="Misal: Paket Pelajar 5Mbps" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Bulanan (Rp)</label>
                            <input type="number" name="price" class="form-control" placeholder="150000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Profile di Mikrotik (Wajib Sama)</label>
                        <input type="text" name="mikrotik_profile" class="form-control" placeholder="Misal: 5mbps-profile" required>
                        <small class="text-muted text-danger">*Pastikan nama ini SAMA PERSIS dengan nama di PPP Profiles / Hotspot User Profile di Winbox.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('paket.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Paket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection