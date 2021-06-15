<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class WAreminder extends Model
{
    use HasFactory;

    public function kirimReminder($jenis_imunisasi, $tanggal, $nohp){
        
        $message = 
        "Jadwal imunisasi selanjutnya
        Imunisasi: $jenis_imunisasi
        Tanggal: $tanggal";     
    
        $response = Http::get('https://api.cybtr.com/imunisasi.php', [
            'key' => "Bhew879drncr9erhm",
            'no' => $nohp,
            'msg' => $message,
        ]);
    }
}
