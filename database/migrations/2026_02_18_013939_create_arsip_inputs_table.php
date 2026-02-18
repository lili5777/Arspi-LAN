<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_inputs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_tahun_kategori_detail')
                ->constrained('tahun_kategori_details')
                ->onDelete('cascade');

            // ===== UMUM =====
            $table->integer('no')->nullable();

            // ===== GAMBAR 1 : USUL MUSNAH =====
            $table->string('kode_klasifikasi')->nullable();
            $table->text('uraian_informasi')->nullable();
            $table->string('kurun_waktu')->nullable();
            $table->string('tingkat_perkembangan')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('no_box')->nullable();
            $table->string('media_simpan')->nullable();
            $table->string('kondisi_fisik')->nullable();
            $table->string('nomor_folder')->nullable();
            $table->string('jangka_simpan')->nullable();
            $table->string('nasib_akhir_arsip')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('lembar')->nullable();

            // ===== GAMBAR 2 : VITAL & PERMANEN =====
            $table->string('jenis_arsip')->nullable();
            $table->string('no_berkas')->nullable();
            $table->string('no_perjanjian_kerjasama')->nullable();
            $table->string('pihak_i')->nullable();
            $table->string('pihak_ii')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->string('media')->nullable();
            $table->string('lokasi_simpan')->nullable();
            $table->string('metode_perlindungan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_inputs');
    }
};
