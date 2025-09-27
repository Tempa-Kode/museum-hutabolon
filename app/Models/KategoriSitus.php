<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSitus extends Model
{
    protected $table = 'kategori_situs';

    protected $fillable = [
        'kategori_id',
        'situs_sejarah_id',
    ];
}
