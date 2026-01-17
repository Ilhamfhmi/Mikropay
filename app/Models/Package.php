<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'router_id',
        'name',
        'mikrotik_profile', // Nama profile di Winbox
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Relasi: Paket ini milik Router siapa?
    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    // Relasi BARU: Paket punya banyak Pelanggan
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    // Relasi: Paket punya banyak Invoice
    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Customer::class);
    }

    /**
     * Get active customers count
     */
    public function getActiveCustomersCountAttribute()
    {
        return $this->customers()->where('status', 'active')->count();
    }
    
    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}