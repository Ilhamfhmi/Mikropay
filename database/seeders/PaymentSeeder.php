<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Customer;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa invoice yang sudah paid
        $invoices = Invoice::where('status', 'paid')->take(10)->get();
        
        foreach ($invoices as $invoice) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'amount' => $invoice->amount,
                'payment_date' => $invoice->paid_at ?? Carbon::now()->subDays(rand(1, 30)),
                'payment_method' => ['cash', 'transfer', 'qris'][rand(0, 2)],
                'reference_number' => 'REF-' . strtoupper(uniqid()),
                'note' => 'Pembayaran invoice ' . $invoice->inv_number,
                'status' => 'success',
                'recorded_by' => 1 // admin user ID
            ]);
        }
        
        $this->command->info('Payments seeded successfully!');
    }
}