<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('router_id')->constrained('routers')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages');
            
            $table->string('name');
            $table->string('phone');
            
            // --- INI YANG KETINGGALAN ---
            $table->text('address')->nullable(); 
            // ---------------------------

            $table->string('username_pppoe')->unique();
            $table->string('password_pppoe');
            $table->date('due_date');
            $table->enum('status', ['active', 'isolated', 'non-active'])->default('active');
            $table->boolean('auto_isolate')->default(true); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};