<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriDetail extends Model
{
    use HasFactory;

    protected $table = 'kategori_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kategori',
        'name',
        'desc',
        'icon',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the kategori that owns this detail
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Get all tahun kategori details for this kategori detail
     */
    public function tahunKategoriDetails(): HasMany
    {
        return $this->hasMany(TahunKategoriDetail::class, 'id_kategori_detail');
    }
}
