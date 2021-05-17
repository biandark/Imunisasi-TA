<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reminder;
use App\Models\Riwayat;
use App\Models\Kondisi;
use Illuminate\Support\Facades\DB;

class sendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder';

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
        $reminder = new Reminder();
    
        $tomorrow = date('Y-m-d', strtotime( "+1 days" ));

        $riwayats = Riwayat::where('tgl_penjadwalan', $tomorrow)->with('imunisasiwajib')->get();

        $riwayatpilihans = DB::table('kondisis')
        ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
        ->where('tgl_rekom', $tomorrow)
        ->get();

        foreach($riwayats as $riwayat) {
            $reminder->sendReminder($riwayat->imunisasiwajib->jenis);
        }
        foreach($riwayatpilihans as $riwayatpilihan) {
            $reminder->sendReminder($riwayatpilihan->nama);
        }

        $this->info('Success');
    }
}
