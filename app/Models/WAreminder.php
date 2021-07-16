<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class WAreminder extends Model
{
    use HasFactory;

    public function kirimReminder($jenis_imunisasi, $tanggal, $nohp, $nama, $link){
        $message = 
        "[IMUNISASI SELANJUTNYA] \n\nJadwal imunisasi selanjutnya \nNama : $nama \nImunisasi : $jenis_imunisasi \nTanggal : $tanggal \nPastikan anak anda dalam kondisi fit. Jika ingin mengetahui mengenai imunisasi dapat mengunjungi $link";     
    
        $response = Http::get('https://api.cybtr.com/imunisasi.php', [
            'key' => "Bhew879drncr9erhm",
            'no' => $nohp,
            'msg' => $message,
        ]);
        
    }
}
