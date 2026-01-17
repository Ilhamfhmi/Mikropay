<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;

class InvoiceController extends Controller
{
    // 1. READ: Daftar Tagihan
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->get();
        return view('tagihan.index', compact('invoices'));
    }

    // 2. CREATE: Form Buat Tagihan
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('tagihan.create', compact('customers'));
    }

    // 3. STORE: Simpan Tagihan
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'period' => 'required|date',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $invNumber = 'INV-' . date('Ymd') . '-' . rand(100, 999);

        Invoice::create([
            'customer_id' => $request->customer_id,
            'inv_number' => $invNumber,
            'period' => $request->period,
            'amount' => $customer->package->price,
            'status' => 'unpaid',
        ]);

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dibuat!');
    }

    // 4. EDIT: Form Edit (Hanya jika belum lunas)
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Cegah edit jika sudah lunas
        if ($invoice->status == 'paid') {
            return redirect()->back()->with('error', 'Tagihan yang sudah LUNAS tidak bisa diedit!');
        }

        $customers = Customer::all();
        return view('tagihan.edit', compact('invoice', 'customers'));
    }

    // 5. UPDATE: Simpan Perubahan
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Cegah update jika sudah lunas
        if ($invoice->status == 'paid') {
            return redirect()->back()->with('error', 'Gagal update. Tagihan sudah lunas.');
        }

        $request->validate([
            'period' => 'required|date',
            'amount' => 'required|numeric', // Admin boleh ubah harga manual
        ]);

        $invoice->update([
            'period' => $request->period,
            'amount' => $request->amount,
            // Customer & No Invoice sebaiknya jangan diubah biar history aman
        ]);

        return redirect()->route('tagihan.index')->with('success', 'Data Tagihan berhasil dikoreksi!');
    }

    // 6. DESTROY: Hapus Tagihan
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        // Opsional: Cegah hapus jika sudah lunas (tergantung kebijakan Anda)
        // if ($invoice->status == 'paid') { ... }

        $invoice->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    // 7. EXTRA: Tombol Bayar Cepat
    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Pembayaran diterima! Status LUNAS.');
    }

    // Dummy Show
    public function show($id) { return back(); }
}