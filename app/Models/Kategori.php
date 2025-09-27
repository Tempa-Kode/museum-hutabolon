<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    public function situsSejarah() : BelongsToMany
    {
        return $this->belongsToMany(SitusSejarah::class, 'kategori_situs', 'kategori_id', 'situs_sejarah_id');
    }
}
