<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Database/migrations/xxxx_xx_xx_create_kategori_keuangan_table.php
        Schema::create('kategori_keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_keuangan');
    }
};
