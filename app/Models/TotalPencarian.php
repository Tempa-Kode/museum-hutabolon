<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalPencarian extends Model
{
    protected $table = 'total_pencarian';

    protected $fillable = [
        'situs_sejarah_id',
        'jlh_pencarian',
    ];

    public function situsSejarah()
    {
        return $this->belongsTo(SitusSejarah::class, 'situs_sejarah_id');
    }
}
