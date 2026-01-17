<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('name');       // Nama Router (misal: Mikrotik Pusat)
            $table->string('ip_address'); // IP Mikrotik
            $table->string('username');   // User API
            $table->string('password');   // Password API
            $table->integer('port')->default(8728); // Port API Default
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};