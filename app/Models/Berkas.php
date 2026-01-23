<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'berkas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_tahun_kategori_detail',
        'name',
        'date',
        'size',
        'file_path',
        'original_name',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tahun kategori detail that owns this berkas
     */
    public function tahunKategoriDetail(): BelongsTo
    {
        return $this->belongsTo(TahunKategoriDetail::class, 'id_tahun_kategori_detail');
    }

    /**
     * Format size attribute
     */
    protected function sizeFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                $bytes = (int) $this->size;
                if ($bytes >= 1073741824) {
                    return number_format($bytes / 1073741824, 2) . ' GB';
                } elseif ($bytes >= 1048576) {
                    return number_format($bytes / 1048576, 2) . ' MB';
                } elseif ($bytes >= 1024) {
                    return number_format($bytes / 1024, 2) . ' KB';
                } else {
                    return $bytes . ' bytes';
                }
            }
        );
    }
}
