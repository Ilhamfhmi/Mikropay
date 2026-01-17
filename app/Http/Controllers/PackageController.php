<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Router;

class PackageController extends Controller
{
    // 1. READ: Tampilkan Daftar Paket
    public function index()
    {
        $packages = Package::with('router')->get();
        return view('paket.index', compact('packages'));
    }

    // 2. CREATE: Tampilkan Form Tambah
    public function create()
    {
        $routers = Router::all();
        return view('paket.create', compact('routers'));
    }

    // 3. STORE: Simpan Paket Baru
    public function store(Request $request)
    {
        $request->validate([
            'router_id' => 'required',
            'name' => 'required',
            'mikrotik_profile' => 'required',
            'price' => 'required|numeric',
        ]);

        Package::create($request->except('_token'));

        return redirect()->route('paket.index')->with('success', 'Paket internet berhasil dibuat!');
    }

    // 4. EDIT: Tampilkan Form Edit
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $routers = Router::all(); // Kita butuh list router untuk dropdown
        return view('paket.edit', compact('package', 'routers'));
    }

    // 5. UPDATE: Simpan Perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'router_id' => 'required',
            'name' => 'required',
            'mikrotik_profile' => 'required',
            'price' => 'required|numeric',
        ]);

        $package = Package::findOrFail($id);
        $package->update($request->except(['_token', '_method']));

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui!');
    }

    // 6. DESTROY: Hapus Paket
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}