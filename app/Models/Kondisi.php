<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kondisi extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tgl_lahir', 'gender', 'travelling', 'kondisi', 'tgl_brkt', 'imunisasisblm', 'tgl', 
        'usia', 'imunisasi', 'tgl_rekom'                                                                                   
    ];
}
