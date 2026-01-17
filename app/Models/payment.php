<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_number',
        'note',
        'status',
        'recorded_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    /**
     * Get the invoice associated with the payment.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the customer associated with the payment.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the admin who recorded the payment.
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope a query to only include successful payments.
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include failed payments.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Get the payment's status badge.
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'success' => ['class' => 'bg-success-opacity-10 text-success border-success-opacity-25', 'label' => 'Sukses'],
            'pending' => ['class' => 'bg-warning-opacity-10 text-warning border-warning-opacity-25', 'label' => 'Pending'],
            'failed' => ['class' => 'bg-danger-opacity-10 text-danger border-danger-opacity-25', 'label' => 'Gagal']
        ];

        $status = $this->status;
        return $statuses[$status] ?? $statuses['pending'];
    }
    
    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}