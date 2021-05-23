<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    use HasFactory;

    protected $table = 'imunisasis';

    protected $fillable = [
        'nama', 'manfaat', 'indikasi', 'kontraindikasi', 'dosis', 'harga'                                                                              
    ];
}
