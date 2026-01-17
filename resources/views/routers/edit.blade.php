@extends('layouts.app')

@section('title', 'Edit Router')
@section('page-title', 'Edit Data Router')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('routers.update', $router->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label class="form-label fw-bold">Nama Identitas Router</label>
                        <input type="text" name="name" class="form-control" value="{{ $router->name }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">IP Address / Domain (VPN)</label>
                            <input type="text" name="ip_address" class="form-control" value="{{ $router->ip_address }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Port API</label>
                            <input type="number" name="port" class="form-control" value="{{ $router->port }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Username API</label>
                            <input type="text" name="username" class="form-control" value="{{ $router->username }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Password API</label>
                            <input type="text" name="password" class="form-control" value="{{ $router->password }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('routers.index') }}" class="btn btn-light text-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-save me-2"></i> Update Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection