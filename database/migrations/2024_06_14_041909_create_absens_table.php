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
        Schema::create('absens', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('id_pelanggan'); // Foreign key to the 'pelanggan' table
            $table->unsignedBigInteger('id_jadwal'); // Foreign key to the 'jadwal' table
            $table->enum('status', ['hadir', 'tidak hadir', 'izin']); // Enum for attendance status
            $table->string('bukti_surat')->nullable(); // Nullable column for supporting documents
            $table->date('tanggal'); // Date of the attendance record
    
            // Add foreign key constraints
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->foreign('id_jadwal')->references('id')->on('jadwals')->onDelete('cascade');

            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
