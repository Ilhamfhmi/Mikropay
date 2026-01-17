@extends('layouts.app')

@section('title', 'Edit Tagihan')
@section('page-title', 'Koreksi Tagihan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Anda sedang mengedit tagihan <b>{{ $invoice->inv_number }}</b>.
                </div>

                <form action="{{ route('tagihan.update', $invoice->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pelanggan</label>
                        <input type="text" class="form-control bg-light" value="{{ $invoice->customer->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Periode Tagihan</label>
                        <input type="date" name="period" class="form-control" value="{{ $invoice->period }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nominal Tagihan (Rp)</label>
                        <input type="number" name="amount" class="form-control" value="{{ $invoice->amount }}" required>
                        <small class="text-muted">Ubah nominal jika ingin memberikan diskon atau biaya tambahan manual.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('tagihan.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection