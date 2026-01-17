@extends('layouts.app')

@section('title', 'Buat Tagihan')
@section('page-title', 'Buat Tagihan Manual')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('tagihan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Pelanggan</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">-- Cari Nama Pelanggan --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->name }} (Paket: {{ $c->package->name ?? '-' }} - Rp {{ number_format($c->package->price ?? 0) }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Nominal tagihan akan otomatis sesuai harga paket.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Periode Tagihan</label>
                        <input type="date" name="period" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('tagihan.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Buat Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection