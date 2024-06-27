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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('id_user')->nullable(); // ID user yang terkait
            $table->unsignedBigInteger('id_pelanggan'); // ID pelanggan yang terkait
            $table->date('tanggal_pesan'); // Tanggal pemesanan
            $table->date('tanggal_ambil'); // Tanggal pengambilan
            $table->integer('total_harga'); // Total harga tanpa auto_increment
            $table->integer('total_bayar')->default(0); // Total bayar dengan default 0
            $table->enum('status_pesanan', ['selesai', 'belum']); // Status pesanan
            $table->enum('status_ambil', ['sudah', 'belum']); // Status pengambilan

            $table->timestamps(); // created_at dan updated_at
            
            // Foreign keys
            // $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
