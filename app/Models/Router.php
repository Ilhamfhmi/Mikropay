<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use HasFactory;

    // KITA IZINKAN KOLOM INI UNTUK DIISI DARI FORM
    protected $fillable = [
        'name',
        'ip_address',
        'username',
        'password',
        'port',
        'status' // tambahkan status field
    ];

    // Relasi: Router punya banyak Paket
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    // Relasi: Router punya banyak Pelanggan
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get active customers count
     */
    public function getActiveCustomersCountAttribute()
    {
        return $this->customers()->where('status', 'active')->count();
    }
    
    /**
     * Get total customers count
     */
    public function getTotalCustomersCountAttribute()
    {
        return $this->customers()->count();
    }
}