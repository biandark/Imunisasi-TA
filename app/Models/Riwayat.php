<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayats';

    protected $fillable = [
        'tgl_penjadwalan',
        'tgl_diberikan',
        'status',
        'baby_id',
        'imunisasiwajib_id',
    ];

    public function imunisasiwajib()
    {
        return $this->belongsTo(Imunisasiwajib::class);
    }
}
