<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GambarVidio extends Model
{
    protected $table = 'gambar_vidio';

    protected $fillable = [
        'situs_sejarah_id',
        'jenis',
        'link',
    ];

    public function situsSejarah() : BelongsTo
    {
        return $this->belongsTo(SitusSejarah::class);
    }
}
