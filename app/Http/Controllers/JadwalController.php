<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Kondisi;
use App\Models\Imunisasi;
use App\Models\Jadwal;
use App\Models\Baby;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Auth;
use Carbon\Carbon;
use DateTime;
use DateInterval;


class JadwalController extends Controller
{
    public function __construct() 
    {
     $this->middleware('auth');
    }
    
    public function index($baby_id) 
    {
        $jadwalbayi = Kondisi::where('baby_id', $baby_id)->first();
        $kosong = empty($jadwalbayi);

        if ($kosong) {
            return redirect()->route('kondisi', ['baby_id' => $baby_id])->with('message', 'Buat jadwal imunisasi baru terlebih dahulu.');;
        }

        $baby = Baby::where('id', $baby_id)->first();
        $jadwals = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('kondisis.baby_id', $baby_id)
            ->get();

        return Inertia::render('riwayat', [
            'baby' => $baby,
            'jadwals' => $jadwals,
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'status' => ['required'],
        ])->validate();
  
        Jadwal::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
    }

    public function update($baby_id, Request $request)
    {
        Validator::make($request->all(), [
            'status' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Jadwal::find($request->input('id'))->update($request->all());
            
        }
        $baby = Baby::where('id', $baby_id)->first();

        $done = DB::table('kondisis')
        ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->pluck('imunisasi')->toArray();
        $done = Arr::flatten($done);
        $done = json_encode($done);
        
        //dd($done);
        $flu = DB::table('kondisis')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('kondisis.baby_id', $baby->id)
            ->where('jadwals.status', 'Sudah Dilakukan')
            ->where('kondisis.imunisasi',29)
            ->first();
            if (!empty($flu)) {
                $flu = $flu->tgl_pelaksanaan;
            }
        $je = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',21)
        ->first();
        if (!empty($je)) {
            $je = $je->tgl_pelaksanaan;
        }
        $hepaa = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',11)
        ->first();
        if (!empty($hepaa)) {
            $hepaa = $hepaa->tgl_pelaksanaan;
        }
        $pcv3 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',5)
        ->first();
        if (!empty($pcv3)) {
            $pcv3 = $pcv3->tgl_pelaksanaan;
        }
        $pcv2 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',4)
        ->first();
        if (!empty($pcv2)) {
            $pcv2 = $pcv2->tgl_pelaksanaan;
        }
        $hepb3 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',24)
        ->first();
        if (!empty($hepb3)) {
            $hepb3 = $hepb3->tgl_pelaksanaan;
        } 
        $hepb2 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',24)
        ->first();
        if (!empty($hepb2)) {
            $hepb2 = $hepb2->tgl_pelaksanaan;
        }
        $dbd3 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',27)
        ->first();
        if (!empty($dbd3)) {
            $dbd3 = $dbd3->tgl_pelaksanaan;
        }  
        $dbd2 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',26)
        ->first();
        if (!empty($dbd2)) {
            $dbd2 = $dbd2->tgl_pelaksanaan;
        } 
        $var = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',7)
        ->first();
        if (!empty($var)) {
            $var = $var->tgl_pelaksanaan;
        }
        $tif = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',9)
        ->first();
        if (!empty($tif)) {
            $tif = $tif->tgl_pelaksanaan;
        } 
        $hpv2 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',13)
        ->first();
        if (!empty($hpv2)) {
            $hpv2 = $hpv2->tgl_pelaksanaan;
        }  
        $hpv3 = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',16)
        ->first();
        if (!empty($hpv3)) {
            $hpv3 = $hpv3->tgl_pelaksanaan;
        }
        $hpv2bi = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',15)
        ->first();
        if (!empty($hpv2bi)) {
            $hpv2bi = $hpv2bi->tgl_pelaksanaan;
        } 
        $hpv3q = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',19)
        ->first();
        if (!empty($hpv3q)) {
            $hpv3q = $hpv3q->tgl_pelaksanaan;
        }  
        $hpv2q = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',18)
        ->first();
        if (!empty($hpv2q)) {
            $hpv2q = $hpv2q->tgl_pelaksanaan;
        } 
        $rot = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->where('kondisis.baby_id', $baby->id)
        ->where('jadwals.status', 'Sudah Dilakukan')
        ->where('kondisis.imunisasi',31)
        ->first();
        if (!empty($rot)) {
            $rot = $rot->tgl_pelaksanaan;
        }          
                
        app('App\Http\Controllers\JadwalController')->aturan($baby->id, $baby->ttl, $done, $je, 
        $hepaa, $pcv3, $pcv2, $hepb3, $hepb2, $dbd3, $dbd2, $flu, $var, $tif, $hpv2, $hpv3, $hpv2bi, 
        $hpv3q, $hpv2q, $rot);

        return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
    }

    public function aturan($baby, $ttl, $done, $je, 
    $hepaa, $pcv3, $pcv2, $hepb3, $hepb2, $dbd3, $dbd2, $flu, $var, $tif, $hpv2, $hpv3, 
    $hpv2bi, $hpv3q, $hpv2q, $rot)
    {
        $now = Carbon::now();
        $im = Imunisasi::get();
        $usia = $now->diffInMonths($ttl);
        $done = json_decode($done);

        //JE 2
        if (in_array("21", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 22)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($je)->addMonths(12);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[21]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]); 
            }
        } 
        //hepatitis A 2
        if ($usia >= 12 AND in_array("11", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 12)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hepaa)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[11]->id;
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //PCV 3 5-6 bulan
        if ( $usia <= 6 AND in_array("5", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 6)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($pcv3)->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[5]->id; //pcv 3
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //PCV 2 7-12 bulan
        if (($usia >= 7 AND $usia < 12) AND in_array("4", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($pcv2)->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[4]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //PCV 2 2-5 bulan, 12-23 bulan
        if ((($usia >= 2 AND $usia <= 5) OR ($usia >= 12 AND $usia <= 23)) AND in_array("4", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($pcv2)->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[4]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Hepatitis b 3
        if (in_array("24", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 25)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hepb3)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[24]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Hepatitis b 2
        if (in_array("23", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 24)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hepb2)->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[23]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Dengue 3
        if (in_array("27", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 28)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($dbd3)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[27]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Dengue 2
        if (in_array("26", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 27)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($dbd2)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[26]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //influenza 2 < 9 tahun
        if ($usia < 108 AND in_array("29", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 30)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($flu)->addMonth(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[29]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //influenza 2 > 9 tahun
        if ($usia >= 108 AND in_array("29", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 30)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($flu)->addMonth(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[29]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Varisela 2 1-12 tahun
        if (in_array("7", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 8)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($var)->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[7]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Tifoid lanjutan
        if ($usia >= 24 AND in_array("9", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 10)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($tif)->addMonths(36);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[9]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //HPV 2 9-14 tahun
        if (($usia >= 108 AND $usia <= 179) AND in_array("13", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 14)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hpv2)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[13]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //HPV 3 bi
        if ($usia >= 180 AND in_array("16", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 17)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hpv3)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[16]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //HPV 2 bi
        if ($usia >= 180 AND in_array("15", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 16)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hpv2bi)->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[15]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //HPV 3 quad
        if ($usia >= 180 AND in_array("19", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 20)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hpv3q)->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[19]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //HPV 2 quad
        if ($usia >= 180 AND in_array("18", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 19)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($hpv2q)->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[18]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }
        //Rotavirus 2
        if ($usia <= 6 AND in_array("31", $done)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby)
            ->where('imunisasis.id', 32)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi = new Kondisi;
                $kondisi->travelling = "Tidak";
                $kondisi->baby_id = $baby;
                $kondisi['tgl_rekom'] = Carbon::parse($rot)->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[31]->id;
                $kondisi->save();

                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                ]);                
            }
        }

    }
    public function show($data)
    {
        $user = Imunisasi::query()
        ->where('jenis', $data)
        ->get();

        return Inertia::render('imunisasi', ['data'=>$user]);
    }
}
