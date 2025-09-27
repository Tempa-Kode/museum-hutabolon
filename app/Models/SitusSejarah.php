<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SitusSejarah extends Model
{
    protected $table = 'situs_sejarah';

    protected $fillable = [
        'nama',
        'slug',
        'lokasi',
        'deskripsi_konten',
    ];

    public function kategori() : BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'kategori_situs', 'situs_sejarah_id', 'kategori_id');
    }

    public function komentar() : HasMany
    {
        return $this->hasMany(KomentarSitusSejarah::class, 'situs_sejarah_id');
    }

    public function favorit() : HasMany
    {
        return $this->hasMany(SitusFavorit::class, 'situs_sejarah_id');
    }
}
