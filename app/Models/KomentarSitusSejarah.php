<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomentarSitusSejarah extends Model
{
    protected $table = 'komentar_situs_sejarah';

    protected $fillable = [
        'situs_sejarah_id',
        'user_id',
        'komentar',
    ];

    public function situsSejarah() : BelongsTo
    {
        return $this->belongsTo(SitusSejarah::class, 'situs_sejarah_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
