<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisasiwajib extends Model
{
    use HasFactory;

    protected $table = 'imunisasiwajibs';

    protected $fillable = [
        'jenis',
        'deskripsi',
        'cara_pemberian_dosis',
        'indikasi',
        'indikasi_kontra',
        'efek_samping',
        'penanganan_efek_samping',
    ];
}
