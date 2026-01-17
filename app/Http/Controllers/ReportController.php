<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // --- 1. DATA KARTU RINGKASAN (Sama seperti sebelumnya) ---
        $totalPemasukan = Invoice::where('status', 'paid')->sum('amount');
        
        $pemasukanBulanIni = Invoice::where('status', 'paid')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');

        $totalTunggakan = Invoice::where('status', 'unpaid')->sum('amount');

        // --- 2. DATA UNTUK GRAFIK PENDAPATAN BULANAN (BAR CHART) ---
        // Ambil data pemasukan tahun ini dikelompokkan per bulan
        $incomePerMonth = Invoice::select(
                DB::raw('MONTH(paid_at) as month'), 
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'paid')
            ->whereYear('paid_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Siapkan array kosong untuk 12 bulan (Jan-Des) agar grafik tidak bolong
        $chartData = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 1; $i <= 12; $i++) {
            // Jika bulan $i ada datanya, pakai datanya. Jika tidak, isi 0.
            $chartData[] = $incomePerMonth[$i] ?? 0;
        }

        // --- 3. DATA UNTUK GRAFIK STATUS (DOUGHNUT CHART) ---
        $countPaid = Invoice::where('status', 'paid')->count();
        $countUnpaid = Invoice::where('status', 'unpaid')->count();

        // --- 4. DATA TABEL TRANSAKSI TERAKHIR ---
        $transactions = Invoice::with('customer')->latest()->take(10)->get();

        return view('laporan.index', compact(
            'totalPemasukan', 
            'pemasukanBulanIni', 
            'totalTunggakan', 
            'transactions',
            'chartData',  // Data angka untuk grafik batang
            'months',     // Label bulan
            'countPaid',  // Jumlah lunas
            'countUnpaid' // Jumlah belum bayar
        ));
    }
}