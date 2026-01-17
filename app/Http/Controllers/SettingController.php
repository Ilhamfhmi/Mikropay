<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data pengaturan pertama
        $setting = Setting::first();

        // Jika belum ada data (pertama kali buka), kita buatkan default
        if (!$setting) {
            $setting = Setting::create([
                'company_name' => 'MikroPay Internet',
                'company_phone' => '08123456789',
                'company_address' => 'Jl. Merdeka No. 1'
            ]);
        }

        return view('pengaturan.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_phone' => 'required',
            'company_address' => 'required',
        ]);

        // Update data yang pertama ditemukan
        $setting = Setting::first();
        
        $setting->update([
            'company_name' => $request->company_name,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
        ]);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}