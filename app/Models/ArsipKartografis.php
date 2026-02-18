<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ArsipKartografis extends Model
{
    use HasFactory;

    protected $table = 'arsip_kartografis';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kategori',
        'name',
        'desc',
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

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    protected function sizeFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                $bytes = (int) $this->size;
                if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
                if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
                if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
                return $bytes . ' bytes';
            }
        );
    }
}