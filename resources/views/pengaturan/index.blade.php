@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Aplikasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-cog me-2"></i> Identitas Usaha (ISP)</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pengaturan.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Perusahaan / Brand</label>
                        <input type="text" name="company_name" class="form-control" value="{{ $setting->company_name ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor WhatsApp Admin</label>
                        <input type="text" name="company_phone" class="form-control" value="{{ $setting->company_phone ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="company_address" class="form-control" rows="3" required>{{ $setting->company_address ?? '' }}</textarea>
                    </div>

                    <div class="alert alert-info mt-4">
                        <small><i class="fas fa-info-circle me-1"></i> Data ini akan digunakan untuk Kop Laporan dan Struk Tagihan.</small>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection