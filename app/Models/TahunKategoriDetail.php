<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunKategoriDetail extends Model
{
    use HasFactory;

    protected $table = 'tahun_kategori_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kategori_detail',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the kategori detail that owns this tahun kategori detail
     */
    public function kategoriDetail(): BelongsTo
    {
        return $this->belongsTo(KategoriDetail::class, 'id_kategori_detail');
    }

    /**
     * Get all berkas for this tahun kategori detail
     */
    public function berkas(): HasMany
    {
        return $this->hasMany(Berkas::class, 'id_tahun_kategori_detail');
    }
}
