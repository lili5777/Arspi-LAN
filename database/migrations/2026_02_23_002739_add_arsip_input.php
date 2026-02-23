<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('arsip_inputs', function (Blueprint $table) {
            // ===== TEMPLATE 3 : ARSIP INAKTIF PERSURATAN =====
            $table->string('no_berkas_persuratan')->nullable()->after('no');
            $table->string('unit_kerja')->nullable()->after('no_berkas_persuratan');
            $table->string('nomor_item_arsip')->nullable()->after('unit_kerja');
            $table->string('kode_klasifikasi_persuratan')->nullable()->after('nomor_item_arsip');
            $table->text('uraian_informasi_persuratan')->nullable()->after('kode_klasifikasi_persuratan');
            $table->date('tgl')->nullable()->after('uraian_informasi_persuratan');
            $table->string('tingkat_perkembangan_persuratan')->nullable()->after('tgl');
            $table->string('jumlah_lembar')->nullable()->after('tingkat_perkembangan_persuratan');
            $table->string('no_filling_cabinet')->nullable()->after('jumlah_lembar');
            $table->string('no_laci')->nullable()->after('no_filling_cabinet');
            $table->string('no_folder_persuratan')->nullable()->after('no_laci');
            $table->string('klasifikasi_keamanan')->nullable()->after('no_folder_persuratan');
            $table->text('keterangan_persuratan')->nullable()->after('klasifikasi_keamanan');
        });
    }

    public function down(): void
    {
        Schema::table('arsip_inputs', function (Blueprint $table) {
            $table->dropColumn([
                'no_berkas_persuratan',
                'unit_kerja',
                'nomor_item_arsip',
                'kode_klasifikasi_persuratan',
                'uraian_informasi_persuratan',
                'tgl',
                'tingkat_perkembangan_persuratan',
                'jumlah_lembar',
                'no_filling_cabinet',
                'no_laci',
                'no_folder_persuratan',
                'klasifikasi_keamanan',
                'keterangan_persuratan',
            ]);
        });
    }
};