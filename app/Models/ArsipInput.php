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
        'no_urut',
        'kode_klasifikasi',
        'uraian_informasi',
        'kurun_waktu',
        'jumlah',
        'tingkat_perkembangan',
        'media_simpan',
        'kondisi',
        // Usul Musnah
        'jangka_simpan',
        'nasib_akhir',
        'tanggal_habis_retensi',
        // Vital & Permanen
        'lokasi_simpan',
        'nomor_boks',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_habis_retensi' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tahunKategoriDetail(): BelongsTo
    {
        return $this->belongsTo(TahunKategoriDetail::class, 'id_tahun_kategori_detail');
    }
}