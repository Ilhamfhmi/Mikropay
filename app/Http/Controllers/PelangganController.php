<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Router;
use App\Models\Package;

class PelangganController extends Controller
{
    // 1. READ: Tampilkan Daftar Pelanggan
    public function index()
    {
        $customers = Customer::with(['router', 'package'])->latest()->get();
        return view('pelanggan.index', compact('customers'));
    }

    // 2. CREATE: Form Tambah
    public function create()
    {
        $routers = Router::all();
        $packages = Package::all();
        return view('pelanggan.create', compact('routers', 'packages'));
    }

    // 3. STORE: Simpan Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'router_id' => 'required',
            'package_id' => 'required',
            'username_pppoe' => 'required|unique:customers',
            'password_pppoe' => 'required',
            'due_date' => 'required|date',
            'status' => 'required',
        ]);

        Customer::create($request->except('_token'));

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil didaftarkan!');
    }

    // 4. EDIT: Form Edit
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $routers = Router::all();
        $packages = Package::all();
        
        return view('pelanggan.edit', compact('customer', 'routers', 'packages'));
    }

    // 5. UPDATE: Simpan Perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'router_id' => 'required',
            'package_id' => 'required',
            // Validasi unik kecuali punya diri sendiri
            'username_pppoe' => 'required|unique:customers,username_pppoe,'.$id, 
            'password_pppoe' => 'required',
            'due_date' => 'required|date',
            'status' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->except(['_token', '_method']));

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil diperbarui!');
    }

    // 6. DESTROY: Hapus Pelanggan
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
    
    // Show (Dummy, redirect back aja)
    public function show($id) { return back(); }
}