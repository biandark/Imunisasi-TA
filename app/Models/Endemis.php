<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endemis extends Model
{
    use HasFactory;

    protected $fillable = [
        'imunisasi_id', 'daerah'                                                                                
    ];
}
