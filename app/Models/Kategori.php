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
        'type', // tambah
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategoriDetails(): HasMany
    {
        return $this->hasMany(KategoriDetail::class, 'id_kategori');
    }

    public function arsipKartografis(): HasMany
    {
        return $this->hasMany(ArsipKartografis::class, 'id_kategori');
    }

    // Helper type
    public function isUpload(): bool { return $this->type === 'upload'; }
    public function isInput(): bool  { return $this->type === 'input'; }
    public function isDirect(): bool { return $this->type === 'direct'; }
}