<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipInput extends Model
{
    use HasFactory;

    protected $table = 'arsip_inputs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_tahun_kategori_detail',

        // UMUM
        'no',

        // TEMPLATE 1 – USUL MUSNAH
        'kode_klasifikasi',
        'uraian_informasi',
        'kurun_waktu',
        'tingkat_perkembangan',
        'jumlah',
        'no_box',
        'media_simpan',
        'kondisi_fisik',
        'nomor_folder',
        'jangka_simpan',
        'nasib_akhir_arsip',
        'keterangan',
        'lembar',

        // TEMPLATE 2 – VITAL & PERMANEN
        'jenis_arsip',
        'no_berkas',
        'no_perjanjian_kerjasama',
        'pihak_i',
        'pihak_ii',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'media',
        'lokasi_simpan',
        'metode_perlindungan',

        // TEMPLATE 3 – ARSIP INAKTIF PERSURATAN
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
    ];

    protected $casts = [
        'tanggal_berlaku'  => 'date',
        'tanggal_berakhir' => 'date',
        'tgl'              => 'date',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    public function tahunKategoriDetail(): BelongsTo
    {
        return $this->belongsTo(
            TahunKategoriDetail::class,
            'id_tahun_kategori_detail'
        );
    }
}