<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'router_id',
        'package_id',
        'name',
        'phone',
        'address', // Pastikan kolom ini ada di migration Anda
        'username_pppoe',
        'password_pppoe',
        'due_date',
        'status',
        'auto_isolate'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    // Relasi: Pelanggan punya 1 Router
    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    // Relasi: Pelanggan punya 1 Paket
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relasi BARU: Pelanggan punya banyak Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Relasi BARU: Pelanggan punya banyak Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relasi: Invoice terbaru pelanggan
    public function latestInvoice()
    {
        return $this->hasOne(Invoice::class)->latestOfMany();
    }

    // Relasi: Payment terbaru pelanggan
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Scope a query to only include active customers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive customers.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include isolated customers.
     */
    public function scopeIsolated($query)
    {
        return $query->where('status', 'isolated');
    }

    /**
     * Get the customer's status badge.
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'active' => ['class' => 'bg-success-opacity-10 text-success border-success-opacity-25', 'label' => 'Aktif'],
            'inactive' => ['class' => 'bg-warning-opacity-10 text-warning border-warning-opacity-25', 'label' => 'Non-Aktif'],
            'isolated' => ['class' => 'bg-danger-opacity-10 text-danger border-danger-opacity-25', 'label' => 'Terisolir']
        ];

        $status = $this->status;
        return $statuses[$status] ?? $statuses['inactive'];
    }
    
    /**
     * Get total payments amount
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'success')->sum('amount');
    }
    
    /**
     * Get total unpaid invoices amount
     */
    public function getTotalUnpaidAttribute()
    {
        return $this->invoices()->where('status', 'unpaid')->sum('amount');
    }
}