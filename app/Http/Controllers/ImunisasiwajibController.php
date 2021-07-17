<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Imunisasiwajib;
use App\Models\WAreminder;
use App\Models\Riwayat;
use App\Models\Kondisi;
use Illuminate\Support\Facades\DB;

class ImunisasiwajibController extends Controller
{
    public function __construct() 
    {
     $this->middleware('auth');
    }
    
    public function detail($id) {
        //ambil data id dari url > detail/1
        // data di tabel imunisasi
        $imunisasiwajib = Imunisasiwajib::find($id);
        //return view DetailImunisasi
        return Inertia::render('DetailImunisasiWajib', [
            'imunisasiwajib' => $imunisasiwajib,
        ]);
    }
    public function info(){
        $imunisasiwajibs = Imunisasiwajib::get();
        // return Inertia::render('InfoImunisasiWajib', [
        //     'imunisasiwajibs' => $imunisasiwajibs,
        // ]);

        $awal = microtime(true);

        $reminder = new WAreminder();

        $dayafter = date('Y-m-d', strtotime( "+2 days" ));
        $tomorrow = date('Y-m-d', strtotime( "+1 days" ));
        $now = date('Y-m-d', strtotime("now"));
        
        $riwayats = DB::table('riwayats')
        ->join('babies', 'riwayats.baby_id', '=', 'babies.id')
        ->join('users', 'babies.user_id', '=', 'users.id')
        ->join('imunisasiwajibs', 'riwayats.imunisasiwajib_id', '=', 'imunisasiwajibs.id')
        ->where('tgl_penjadwalan', $tomorrow)
        ->orWhere('tgl_penjadwalan', $dayafter)
        ->orWhere('tgl_penjadwalan', $now)
        ->get();

        $riwayatpilihans = DB::table('kondisis')
        ->join('babies', 'kondisis.baby_id', '=', 'babies.id')
        ->join('users', 'babies.user_id', '=', 'users.id')
        ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
        ->where('tgl_rekom', $tomorrow)
        ->orWhere('tgl_rekom', $dayafter)
        ->orWhere('tgl_rekom', $now)
        ->get();

        foreach($riwayats as $riwayat) {
            $reminder->kirimReminder($riwayat->jenis, $riwayat->tgl_penjadwalan, $riwayat->whatsappno, $riwayat->nama, $link = "http://imun.site/info");
        }
        foreach($riwayatpilihans as $riwayatpilihan) {
            $reminder->kirimReminder($riwayatpilihan->jenis, $riwayatpilihan->tgl_rekom, $riwayatpilihan->whatsappno, $riwayatpilihan->nama, $link = "http://imun.site/daftarimunisasi");
           
        }

        $akhir = microtime(true);
        $lama = $akhir - $awal;
        echo "Lama eksekusi script adalah: ".$lama." microsecond";
        
        
    }
}