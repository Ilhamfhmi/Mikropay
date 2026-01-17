<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            // Menghubungkan paket ke router tertentu
            $table->foreignId('router_id')->constrained('routers')->onDelete('cascade');
            
            $table->string('name');             // Nama Paket di Web (misal: Paket Pelajar)
            $table->string('mikrotik_profile'); // Nama Profile ASLI di Winbox (PENTING! harus sama persis)
            $table->decimal('price', 10, 2);    // Harga Paket
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};