<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class PaymentController extends Controller
{
    public function index()
    {
        // Ambil hanya invoice yang sudah LUNAS (paid), urutkan dari yang terbaru dibayar
        $payments = Invoice::with('customer')
                           ->where('status', 'paid')
                           ->orderBy('paid_at', 'desc')
                           ->get();
                           
        return view('pembayaran.index', compact('payments'));
    }
    
    // Fitur Cetak Struk (Nanti bisa dikembangkan)
    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('pembayaran.print', compact('invoice'));
    }
}