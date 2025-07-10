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
        Schema::create('produk_lokasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->onDelete('cascade');
            $table->foreignId('lokasi_id')
                ->constrained('lokasi')
                ->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->timestamps();

            $table->unique(['produk_id', 'lokasi_id'], 'produk_lokasi_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_lokasi');
    }
};
