<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
        'thumbnail',
        'nama_event',
        'tanggal_event',
        'deskripsi_event',
        'waktu_event',
    ];
}
