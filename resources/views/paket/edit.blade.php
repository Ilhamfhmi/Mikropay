@extends('layouts.app')

@section('title', 'Edit Paket')
@section('page-title', 'Edit Data Paket')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('paket.update', $package->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Router</label>
                        <select name="router_id" class="form-select" required>
                            <option value="">-- Pilih Router --</option>
                            @foreach($routers as $router)
                                <option value="{{ $router->id }}" {{ $package->router_id == $router->id ? 'selected' : '' }}>
                                    {{ $router->name }} ({{ $router->ip_address }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Paket (Web)</label>
                            <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Bulanan (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ $package->price }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Profile di Mikrotik</label>
                        <input type="text" name="mikrotik_profile" class="form-control" value="{{ $package->mikrotik_profile }}" required>
                        <small class="text-muted text-danger">*Harus SAMA PERSIS dengan di Winbox.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('paket.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">Update Paket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection