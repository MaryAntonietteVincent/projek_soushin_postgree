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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id(); // Kolom 'id' sebagai primary key
            $table->string('nama_produk'); // Kolom untuk nama produk
            $table->integer('harga', false, true, 7); // Kolom untuk harga produk, signed integer, length 7 digits
            $table->text('deskripsi'); // Kolom untuk deskripsi produk
            $table->string('gambar'); // Kolom untuk path atau nama file gambar
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
