<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WAreminder;
use App\Models\Riwayat;
use App\Models\Kondisi;
use Illuminate\Support\Facades\DB;

class SendWA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsappreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
            $reminder->kirimReminder( $riwayat->jenis, $riwayat->tgl_penjadwalan, $riwayat->whatsappno, $riwayat->nama, $link = "http://imun.site/info");
        }
        foreach($riwayatpilihans as $riwayatpilihan) {
            $reminder->kirimReminder($riwayatpilihan->jenis, $riwayatpilihan->tgl_rekom, $riwayatpilihan->whatsappno, $riwayatpilihan->nama, $link = "http://imun.site/daftarimunisasi");
           
        }

        $akhir = microtime(true);
        $lama = $akhir - $awal;
        echo "<p>Lama eksekusi script adalah: ".$lama." microsecond</p>";
        $this->info('Success');
    }
}
