<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'inv_number', // Nomor Tagihan (INV-202601-001)
        'period',     // Periode tagihan (tanggal)
        'amount',     // Jumlah uang
        'status',     // unpaid / paid
        'paid_at',    // Kapan dibayar
    ];

    protected $casts = [
        'period' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    // Relasi: Tagihan ini milik Pelanggan siapa?
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi BARU: Tagihan bisa punya banyak Payment (jika ada cicilan)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relasi: Tagihan terakhir payment
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Scope a query to only include unpaid invoices.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    /**
     * Scope a query to only include paid invoices.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include overdue invoices.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'unpaid')
                    ->whereDate('period', '<', now());
    }

    /**
     * Get the invoice's status badge.
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'unpaid' => ['class' => 'bg-warning-opacity-10 text-warning border-warning-opacity-25', 'label' => 'Belum Bayar'],
            'paid' => ['class' => 'bg-success-opacity-10 text-success border-success-opacity-25', 'label' => 'Lunas'],
            'overdue' => ['class' => 'bg-danger-opacity-10 text-danger border-danger-opacity-25', 'label' => 'Jatuh Tempo']
        ];

        // Cek jika unpaid dan sudah lewat period
        $status = $this->status;
        if ($status === 'unpaid' && $this->period < now()) {
            $status = 'overdue';
        }

        return $statuses[$status] ?? $statuses['unpaid'];
    }

    /**
     * Check if invoice is overdue.
     */
    public function getIsOverdueAttribute()
    {
        return $this->status === 'unpaid' && $this->period < now();
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}