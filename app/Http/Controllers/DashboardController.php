<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Router;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== 1. STATISTIK PELANGGAN =====
        $totalPelanggan = Customer::count();
        $pelangganAktif = Customer::where('status', 'active')->count();
        $pelangganNonAktif = Customer::where('status', 'inactive')->count();
        $pelangganTerisolir = Customer::where('status', 'isolated')->count();
        $pelangganTrial = Customer::where('status', 'trial')->count();
        
        // ===== 2. STATISTIK TAGIHAN =====
        $tagihanPending = Invoice::where('status', 'unpaid')->count();
        $tagihanPaid = Invoice::where('status', 'paid')->count();
        
        // Hitung tagihan overdue (belum bayar dan PERIOD sudah lewat)
        $today = Carbon::today();
        $tagihanOverdue = Invoice::where('status', 'unpaid')
            ->whereDate('period', '<', $today)
            ->count();
        
        $tagihanCancelled = Invoice::where('status', 'cancelled')->count();
        
        // ===== 3. STATISTIK KEUANGAN =====
        $uangPending = Invoice::where('status', 'unpaid')->sum('amount');
        $uangPaid = Invoice::where('status', 'paid')->sum('amount');
        $totalPendapatan = Payment::where('status', 'success')->sum('amount');
        $totalPendapatanBulanLalu = Payment::where('status', 'success')
            ->whereMonth('payment_date', Carbon::now()->subMonth()->month)
            ->whereYear('payment_date', Carbon::now()->subMonth()->year)
            ->sum('amount');
        
        // ===== 4. DATA BULAN INI =====
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        
        $pendapatanBulanIni = Payment::where('status', 'success')
            ->whereMonth('payment_date', $bulanIni)
            ->whereYear('payment_date', $tahunIni)
            ->sum('amount');
        
        // PERBAIKAN DISINI: Pakai 'period' bukan 'due_date'
        $tagihanBulanIni = Invoice::whereMonth('period', $bulanIni)
            ->whereYear('period', $tahunIni)
            ->count();
            
        $pelangganBaruBulanIni = Customer::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();
        
        $pembayaranBulanIni = Payment::where('status', 'success')
            ->whereMonth('payment_date', $bulanIni)
            ->whereYear('payment_date', $tahunIni)
            ->count();
        
        // ===== 5. DATA MINGGU INI =====
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $pelangganBaruMingguIni = Customer::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();
        
        $pendapatanMingguIni = Payment::where('status', 'success')
            ->whereBetween('payment_date', [$startOfWeek, $endOfWeek])
            ->sum('amount');
        
        // ===== 6. DATA HARI INI =====
        $pelangganBaruHariIni = Customer::whereDate('created_at', Carbon::today())->count();
        $pembayaranHariIni = Payment::where('status', 'success')
            ->whereDate('payment_date', Carbon::today())
            ->count();
        $pendapatanHariIni = Payment::where('status', 'success')
            ->whereDate('payment_date', Carbon::today())
            ->sum('amount');
        
        // ===== 7. DATA TERBARU =====
        $recentCustomers = Customer::with(['package', 'router'])
            ->latest()
            ->take(8)
            ->get();
            
        $recentPayments = Payment::with(['customer', 'invoice'])
            ->where('status', 'success')
            ->latest()
            ->take(5)
            ->get();
        
        $recentInvoices = Invoice::with(['customer', 'customer.package'])
            ->latest()
            ->take(5)
            ->get();
        
        // ===== 8. STATISTIK PAKET POPULER =====
        $popularPackages = Package::withCount(['customers' => function($query) {
            $query->where('status', 'active');
        }])
        ->orderBy('customers_count', 'desc')
        ->take(5)
        ->get();
        
        // ===== 9. STATISTIK ROUTER =====
        $totalRouter = Router::count();
        $routerAktif = Router::where('status', 'active')->count();
        $routerNonAktif = Router::where('status', 'inactive')->count();
        
        // ===== 10. CHART DATA UNTUK 6 BULAN TERAKHIR =====
        $chartData = $this->getChartData();
        
        // ===== 11. PELANGGAN AKAN JATUH TEMPO BESOK =====
        $pelangganJatuhTempoBesok = Customer::where('status', 'active')
            ->whereDate('due_date', Carbon::tomorrow())
            ->count();
        
        // ===== 12. PELANGGAN SUDAH JATUH TEMPO =====
        $pelangganJatuhTempo = Customer::where('status', 'active')
            ->whereDate('due_date', '<', Carbon::today())
            ->count();
        
        // ===== 13. TAGIHAN AKAN JATUH TEMPO BESOK =====
        $tagihanJatuhTempoBesok = Invoice::where('status', 'unpaid')
            ->whereDate('period', Carbon::tomorrow())
            ->count();
        
        // ===== 14. TAGIHAN SUDAH JATUH TEMPO =====
        $tagihanSudahJatuhTempo = Invoice::where('status', 'unpaid')
            ->whereDate('period', '<', Carbon::today())
            ->count();
        
        // ===== 15. RATA-RATA WAKTU PEMBAYARAN =====
        $avgPaymentTime = $this->getAveragePaymentTime();
        
        // ===== 16. TOP PELANGGAN BERDASARKAN PEMBAYARAN =====
        $topCustomers = $this->getTopCustomers();
        
        return view('dashboard.index', compact(
            // Statistik Pelanggan
            'totalPelanggan', 
            'pelangganAktif',
            'pelangganNonAktif',
            'pelangganTerisolir',
            'pelangganTrial',
            
            // Statistik Tagihan
            'tagihanPending', 
            'tagihanPaid',
            'tagihanOverdue',
            'tagihanCancelled',
            
            // Statistik Keuangan
            'uangPending', 
            'uangPaid',
            'totalPendapatan',
            'totalPendapatanBulanLalu',
            
            // Data Bulan Ini
            'pendapatanBulanIni',
            'tagihanBulanIni',
            'pelangganBaruBulanIni',
            'pembayaranBulanIni',
            
            // Data Minggu Ini
            'pelangganBaruMingguIni',
            'pendapatanMingguIni',
            
            // Data Hari Ini
            'pelangganBaruHariIni',
            'pembayaranHariIni',
            'pendapatanHariIni',
            
            // Data Terbaru
            'recentCustomers',
            'recentPayments',
            'recentInvoices',
            
            // Statistik Paket
            'popularPackages',
            
            // Statistik Router
            'totalRouter',
            'routerAktif',
            'routerNonAktif',
            
            // Chart Data
            'chartData',
            
            // Jatuh Tempo Pelanggan
            'pelangganJatuhTempoBesok',
            'pelangganJatuhTempo',
            
            // Jatuh Tempo Tagihan
            'tagihanJatuhTempoBesok',
            'tagihanSudahJatuhTempo',
            
            // Statistik Lainnya
            'avgPaymentTime',
            'topCustomers'
        ));
    }
    
    /**
     * Get chart data for the last 6 months
     */
    private function getChartData()
    {
        $data = [];
        $months = [];
        $revenues = [];
        $customers = [];
        $invoices = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M');
            $year = $date->format('Y');
            
            // Pendapatan per bulan
            $revenue = Payment::where('status', 'success')
                ->whereMonth('payment_date', $date->month)
                ->whereYear('payment_date', $date->year)
                ->sum('amount');
            
            // Pelanggan baru per bulan
            $newCustomers = Customer::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            // Tagihan per bulan - PERBAIKAN: pakai 'period' bukan 'due_date'
            $invoicesCount = Invoice::whereMonth('period', $date->month)
                ->whereYear('period', $date->year)
                ->count();
            
            $months[] = $month;
            $revenues[] = $revenue;
            $customers[] = $newCustomers;
            $invoices[] = $invoicesCount;
        }
        
        $data['months'] = $months;
        $data['revenues'] = $revenues;
        $data['customers'] = $customers;
        $data['invoices'] = $invoices;
        
        return $data;
    }
    
    /**
     * Get average payment time in days
     */
    private function getAveragePaymentTime()
    {
        $payments = Payment::where('status', 'success')
            ->whereNotNull('invoice_id')
            ->with('invoice')
            ->get();
        
        $totalDays = 0;
        $count = 0;
        
        foreach ($payments as $payment) {
            if ($payment->invoice && $payment->invoice->period && $payment->payment_date) {
                $dueDate = Carbon::parse($payment->invoice->period); // PERBAIKAN: pakai 'period'
                $paymentDate = Carbon::parse($payment->payment_date);
                
                if ($paymentDate->greaterThanOrEqualTo($dueDate)) {
                    $daysLate = $paymentDate->diffInDays($dueDate);
                    $totalDays += $daysLate;
                    $count++;
                }
            }
        }
        
        return $count > 0 ? round($totalDays / $count, 1) : 0;
    }
    
    /**
     * Get top 5 customers by payment amount
     */
    private function getTopCustomers()
    {
        return Customer::select('customers.*', DB::raw('SUM(payments.amount) as total_payment'))
            ->leftJoin('payments', function($join) {
                $join->on('customers.id', '=', 'payments.customer_id')
                     ->where('payments.status', 'success');
            })
            ->groupBy('customers.id')
            ->orderBy('total_payment', 'desc')
            ->take(5)
            ->get();
    }
    
    /**
     * Get dashboard summary for API or widgets
     */
    public function getSummary()
    {
        $totalPelanggan = Customer::count();
        $pelangganAktif = Customer::where('status', 'active')->count();
        $tagihanPending = Invoice::where('status', 'unpaid')->count();
        $uangPending = Invoice::where('status', 'unpaid')->sum('amount');
        
        return response()->json([
            'total_pelanggan' => $totalPelanggan,
            'pelanggan_aktif' => $pelangganAktif,
            'tagihan_pending' => $tagihanPending,
            'uang_pending' => $uangPending,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get recent activities for dashboard
     */
    public function getRecentActivities()
    {
        $activities = [];
        
        // Recent payments
        $payments = Payment::with('customer')
            ->where('status', 'success')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($payment) {
                return [
                    'type' => 'payment',
                    'message' => ($payment->customer->name ?? 'Pelanggan') . ' membayar Rp ' . number_format($payment->amount, 0, ',', '.'),
                    'time' => $payment->created_at->diffForHumans(),
                    'icon' => 'fas fa-money-bill-wave',
                    'color' => 'success'
                ];
            });
        
        // Recent new customers
        $customers = Customer::latest()
            ->take(10)
            ->get()
            ->map(function($customer) {
                return [
                    'type' => 'customer',
                    'message' => $customer->name . ' terdaftar sebagai pelanggan baru',
                    'time' => $customer->created_at->diffForHumans(),
                    'icon' => 'fas fa-user-plus',
                    'color' => 'primary'
                ];
            });
        
        // Recent invoices
        $invoices = Invoice::with('customer')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($invoice) {
                return [
                    'type' => 'invoice',
                    'message' => 'Invoice untuk ' . ($invoice->customer->name ?? 'Pelanggan') . ' sebesar Rp ' . number_format($invoice->amount, 0, ',', '.'),
                    'time' => $invoice->created_at->diffForHumans(),
                    'icon' => 'fas fa-file-invoice',
                    'color' => 'warning'
                ];
            });
        
        // Merge all activities and sort by time
        $activities = collect($payments)->merge($customers)->merge($invoices)
            ->sortByDesc(function($activity) {
                return $activity['time'];
            })
            ->take(10)
            ->values()
            ->all();
        
        return response()->json($activities);
    }
    
    /**
     * Get financial overview for dashboard
     */
    public function getFinancialOverview()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subMonth()->year;
        
        // Current month revenue
        $currentRevenue = Payment::where('status', 'success')
            ->whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)
            ->sum('amount');
        
        // Last month revenue
        $lastMonthRevenue = Payment::where('status', 'success')
            ->whereMonth('payment_date', $lastMonth)
            ->whereYear('payment_date', $lastYear)
            ->sum('amount');
        
        // Revenue growth percentage
        $growthPercentage = 0;
        if ($lastMonthRevenue > 0) {
            $growthPercentage = (($currentRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($currentRevenue > 0) {
            $growthPercentage = 100;
        }
        
        // Total pending amount
        $pendingAmount = Invoice::where('status', 'unpaid')->sum('amount');
        
        // Average revenue per customer
        $totalCustomers = Customer::where('status', 'active')->count();
        $avgRevenuePerCustomer = $totalCustomers > 0 ? $currentRevenue / $totalCustomers : 0;
        
        return [
            'current_revenue' => $currentRevenue,
            'last_month_revenue' => $lastMonthRevenue,
            'growth_percentage' => round($growthPercentage, 2),
            'pending_amount' => $pendingAmount,
            'avg_revenue_per_customer' => round($avgRevenuePerCustomer, 2),
            'total_active_customers' => $totalCustomers
        ];
    }
    
    /**
     * Get quick stats for dashboard widgets
     */
    public function getQuickStats()
    {
        $today = Carbon::today();
        
        return [
            'today' => [
                'payments' => Payment::where('status', 'success')
                    ->whereDate('payment_date', $today)
                    ->count(),
                'revenue' => Payment::where('status', 'success')
                    ->whereDate('payment_date', $today)
                    ->sum('amount'),
                'new_customers' => Customer::whereDate('created_at', $today)->count(),
                'new_invoices' => Invoice::whereDate('created_at', $today)->count()
            ],
            'week' => [
                'payments' => Payment::where('status', 'success')
                    ->whereBetween('payment_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])
                    ->count(),
                'revenue' => Payment::where('status', 'success')
                    ->whereBetween('payment_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])
                    ->sum('amount')
            ],
            'month' => [
                'payments' => Payment::where('status', 'success')
                    ->whereMonth('payment_date', $today->month)
                    ->whereYear('payment_date', $today->year)
                    ->count(),
                'revenue' => Payment::where('status', 'success')
                    ->whereMonth('payment_date', $today->month)
                    ->whereYear('payment_date', $today->year)
                    ->sum('amount')
            ]
        ];
    }
}