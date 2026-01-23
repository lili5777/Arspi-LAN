<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'desc',
        'icon',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all kategori details for this kategori
     */
    
    public function kategoriDetails(): HasMany
    {
        return $this->hasMany(KategoriDetail::class, 'id_kategori');
    }
}
