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
        Schema::create('arsip_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tahun_kategori_detail')
                ->constrained('tahun_kategori_details')->onDelete('cascade');

            // Kolom umum (dipakai semua kategori input)
            $table->integer('no_urut')->nullable();
            $table->string('kode_klasifikasi')->nullable();
            $table->text('uraian_informasi');          // Deskripsi/judul arsip
            $table->string('kurun_waktu')->nullable(); // Misal: 2020-2024
            $table->string('jumlah')->nullable();      // Misal: 5 berkas / 20 lembar
            $table->string('tingkat_perkembangan')->nullable(); // Asli/Fotokopi/dst
            $table->string('media_simpan')->nullable();         // Kertas/Digital/dst
            $table->string('kondisi')->nullable();     // Baik / Rusak

            // Kolom khusus Usul Musnah (nullable untuk Vital & Permanen)
            $table->string('jangka_simpan')->nullable();       // Misal: 5 Tahun
            $table->string('nasib_akhir')->nullable();          // Musnah / Permanen
            $table->date('tanggal_habis_retensi')->nullable();

            // Kolom khusus Vital & Permanen (nullable untuk Usul Musnah)
            $table->string('lokasi_simpan')->nullable();        // Ruang/Rak/Boks
            $table->string('nomor_boks')->nullable();

            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_inputs');
    }
};
