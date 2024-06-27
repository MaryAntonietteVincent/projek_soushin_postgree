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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama atau judul acara
            $table->text('description'); // Deskripsi rinci tentang acara

            $table->date('start_date'); // Tanggal dan waktu kapan acara dimulai
            $table->date('end_date')->nullable(); // Tanggal dan waktu kapan acara berakhir

            $table->string('location'); // Lokasi di mana acara diadakan
            $table->string('organizer'); // Nama penyelenggara atau pihak yang bertanggung jawab atas acara tersebut
   // Jenis acara (misalnya, webinar, konferensi, konser, dll.)

            // Status acara (misalnya, upcoming, ongoing, completed, cancelled)
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled']);

            $table->string('image_event')->nullable(); // URL atau path gambar yang terkait dengan acara
            $table->unsignedBigInteger('id_jenisacara')->nullable();
            $table->foreign('id_jenisacara')->references('id')->on('jenis_acaras')->onDelete('cascade');
            $table->integer('capacity')->nullable(); // Kapasitas atau jumlah maksimal peserta yang dapat menghadiri acara
            $table->integer('price')->nullable(); // Harga tiket atau biaya untuk mengikuti acara
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
