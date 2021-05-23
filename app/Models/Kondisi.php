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

    protected $table = 'kondisis';
    protected $fillable = [
        'baby_id', 'travelling', 'kondisi', 'tgl_brkt', 'imunisasisblm', 'tgl', 'imunisasi', 'tgl_rekom'                                                                                   
    ];

    public function imunisasi()
    {
        return $this->belongsTo(Imunisasi::class);
    }
}
