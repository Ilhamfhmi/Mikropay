<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Router;
use RouterOS\Client;
use RouterOS\Config;

class RouterController extends Controller
{
    // 1. READ: Tampilkan List Router
    public function index()
    {
        $routers = Router::all();
        return view('routers.index', compact('routers'));
    }

    // 2. CREATE: Tampilkan Form Tambah
    public function create()
    {
        return view('routers.create');
    }

    // 3. STORE: Simpan Router Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ip_address' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'required|numeric',
        ]);

        Router::create($request->except('_token'));
        return redirect()->route('routers.index')->with('success', 'Router berhasil ditambahkan!');
    }

    // 4. EDIT: Tampilkan Form Edit
    public function edit($id)
    {
        $router = Router::findOrFail($id);
        return view('routers.edit', compact('router'));
    }

    // 5. UPDATE: Simpan Perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'ip_address' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'required|numeric',
        ]);

        $router = Router::findOrFail($id);
        
        // Update data (kecuali token dan method put)
        $router->update($request->except(['_token', '_method']));

        return redirect()->route('routers.index')->with('success', 'Data Router berhasil diperbarui!');
    }

    // 6. DELETE: Hapus Router
    public function destroy($id)
    {
        $router = Router::findOrFail($id);
        $router->delete();

        return redirect()->route('routers.index')->with('success', 'Router berhasil dihapus.');
    }

    // 7. EXTRA: Cek Koneksi (Ping)
    public function testConnection($id)
    {
        $router = Router::findOrFail($id);
        try {
            $config = (new Config())
                ->set('host', $router->ip_address)
                ->set('port', (int) $router->port)
                ->set('user', $router->username)
                ->set('pass', $router->password)
                ->set('timeout', 3)
                ->set('attempts', 1); 

            $client = new Client($config);
            return redirect()->back()->with('success', 'PING SUKSES! Terhubung ke Mikrotik ' . $router->name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'GAGAL: ' . $e->getMessage());
        }
    }
}