<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SitusFavorit extends Model
{
    protected $table = 'situs_favorit';

    protected $fillable = [
        'pengguna_id',
        'situs_sejarah_id',
    ];

    public function pengguna() : BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function situsSejarah() : BelongsTo
    {
        return $this->belongsTo(SitusSejarah::class, 'situs_sejarah_id');
    }
}
