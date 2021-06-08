<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Kondisi;
use App\Models\Imunisasi;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use App\Models\Baby;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
  
class KondisiController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index($baby_id)
    {
        $id = Auth::user()->id;
        $baby = Baby::where('id', $baby_id)->first();
        return Inertia::render('kondisi', [
            'baby' => $baby,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($baby_id)
    {
        $id = Auth::user()->id;
        $baby = Baby::find($baby_id)->first();
        return Inertia::render('kondisi', [
            'baby' => $baby,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show($baby_id)
    {
        $baby = Baby::where('id', $baby_id)->first();
        $kondisis = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->where('baby_id', $baby->id)
            ->get();

        return Inertia::render('output', [
            'baby' => $baby,
            'kondisis' => $kondisis,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store($baby_id, Request $request)
    {
        $attributes = Validator::make($request->only(['travelling']), [
            'travelling' => ['string'],
        ])->validate();
        
        $kondisi = Kondisi::create($request->all());

        $now = Carbon::now();
        $im = Imunisasi::get();
        $baby = Baby::where('id', $baby_id)->first();
        
        $kondisi['baby_id'] = $baby_id; //baby id
        $kondisiku = json_decode($kondisi['kondisi']); //ubah ke array lagi
        $usia = $now->diffInMonths($baby->ttl); //hitung usia
        
        //aturan
        
        //meningitis
        if ($kondisi['travelling'] == "Ya" AND in_array("Pergi ke daerah endemis meningitis", $kondisiku) ){
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 1)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglbrkt = Carbon::parse($kondisi['tgl_brkt']);
                $kondisi['tgl_rekom'] = $tglbrkt->subDays(15);
                $kondisi['imunisasi'] = $im[0]->id;
                $kondisi->save();
            }
        }
        
        //yellow fever
        if ($usia >= 9 AND $kondisi['travelling'] == "Ya" AND (in_array("Pergi ke daerah endemis yellow fever", $kondisiku) OR in_array("hamil", $kondisiku))) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 2)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglbrkt = Carbon::parse($kondisi['tgl_brkt']);
                $kondisi['tgl_rekom'] = $tglbrkt->subDays(10);
                $kondisi['imunisasi'] = $im[1]->id;
                $kondisi->save();
            }
        }
        //rabies
        if (in_array("Memiliki hewan peliharaan (anjing, kucing, kera)", $kondisiku)) {
            
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 3)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[2]->id;
                $kondisi->save();
            }
            
        }
        //PCV
        if (in_array("Tinggal di lingkungan rokok, padat, panti", $kondisiku)) {
            //PCV 1 2 bulan-dewasa
            if ($usia >= 2) {
                $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 4)
                ->get();
                if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                    if ($kondisi['tgl_rekom'] != NULL) {
                        $kondisi49 = Kondisi::create($request->all());
                        $kondisi49->baby_id = $baby_id; //baby id
                        $tglrekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi49['tgl_rekom'] = $tglrekom->addDays(30);
                        $kondisi49['imunisasi'] = $im[3]->id; //pcv 1
                        $kondisi49->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi49->id,
                        ]);
                    }
                    else {
                        $sekarang = Carbon::now();
                        $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                        $kondisi['imunisasi'] = $im[3]->id; //pcv 1
                        $kondisi->save();
                    }
                }
            }
        }
        //PCV 2 2-5 bulan, 12-23 bulan
        if (($usia >= 2 AND $usia <= 5) OR ($usia >= 12 AND $usia <= 23) AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[4]->id; //pcv 2
                $kondisi->save();
            }
            $pcv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();                    
            if (empty($pcv1->first())) {
                $kondisi10 = Kondisi::create($request->all());
                $kondisi10->baby_id = $baby_id; //baby id
                $kondisi10['tgl_rekom'] = $kondisi['tgl'];
                $kondisi10['imunisasi'] = $im[3]->id; //pcv 1 sudah dilakukan
                $kondisi10->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi10->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //PCV 2 7-12 bulan
        if (($usia >= 7 AND $usia <= 12) AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[4]->id;
                $kondisi->save();
            }
            $pcv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();                    
            if (empty($pcv1->first())) {
                $kondisi12 = Kondisi::create($request->all());
                $kondisi12->baby_id = $baby_id; //baby id
                $kondisi12['tgl_rekom'] = $kondisi['tgl'];
                $kondisi12['imunisasi'] = $im[3]->id; //pcv 1 sudah dilakukan
                $kondisi12->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi12->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //PCV 3 5-6 bulan
        if (($usia >= 5 AND $usia <= 6) AND $kondisi['imunisasisblm'] == "Pneumokokus 2") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 6)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[5]->id; //pcv 3
                $kondisi->save();
            }
            $pcv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();
            if (empty($pcv1->first())) {
                $kondisi13 = Kondisi::create($request->all());
                $kondisi13->baby_id = $baby_id; //baby id
                $kondisi13['tgl_rekom'] = $kondisi['tgl'];
                $kondisi13['imunisasi'] = $im[3]->id; //pcv 1 sudah dilakukan
                $kondisi13->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi13->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $pcv2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($pcv2->first())) {
                $kondisi14 = Kondisi::create($request->all());
                $kondisi14->baby_id = $baby_id; //baby id
                $kondisi14['tgl_rekom'] = $kondisi['tgl'];
                $kondisi14['imunisasi'] = $im[4]->id; //pcv 2 sudah dilakukan
                $kondisi14->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi14->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //PCV dewasa
        if ($usia >= 2) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi['tgl_rekom'] != NULL) {
                    $kondisi50 = Kondisi::create($request->all());
                    $kondisi50->baby_id = $baby_id; //baby id
                    $sekarang = Carbon::now();
                    $kondisi50['tgl_rekom'] = $sekarang->addMonths(5);
                    $kondisi50['imunisasi'] = $im[3]->id; //pcv 1
                    $kondisi50->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi50->id,
                    ]);
                }
                else {
                    $sekarang = Carbon::now();
                    $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                    $kondisi['imunisasi'] = $im[3]->id; //pcv 1
                    $kondisi->save();
                }
            }
        }
        //PCV complete > 6 bulan
        if ($usia >= 7 AND $kondisi['imunisasisblm'] == "Pneumokokus 3") {
            $pcv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();
            if (empty($pcv1->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[3]->id; //pcv 1 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $pcv2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($pcv2->first())) {
                $kondisi14 = Kondisi::create($request->all());
                $kondisi14->baby_id = $baby_id; //baby id
                $kondisi14['tgl_rekom'] = $kondisi['tgl'];
                $kondisi14['imunisasi'] = $im[4]->id; //pcv 2 sudah dilakukan
                $kondisi14->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi14->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $pcv3 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 6)
            ->get();
            if (empty($pcv3->first())) {
                $kondisi15 = Kondisi::create($request->all());
                $kondisi15->baby_id = $baby_id; //baby id
                $kondisi15['tgl_rekom'] = $kondisi['tgl'];
                $kondisi15['imunisasi'] = $im[5]->id; //pcv 3 sudah dilakukan
                $kondisi15->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi15->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }

            return redirect()->route('kondisi.show', $baby_id);
        }
        //PCV complete 7-23 bulan
        if ($usia >= 7 AND $kondisi['imunisasisblm'] == "Pneumokokus 2") {
            $pcv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();
            if (empty($pcv1->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[3]->id; //pcv 1 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $pcv2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($pcv2->first())) {
                $kondisi14 = Kondisi::create($request->all());
                $kondisi14->baby_id = $baby_id; //baby id
                $kondisi14['tgl_rekom'] = $kondisi['tgl'];
                $kondisi14['imunisasi'] = $im[4]->id; //pcv 2 sudah dilakukan
                $kondisi14->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi14->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }

            return redirect()->route('kondisi.show', $baby_id);
        }
        //pcv complete 24 bulan - 5 tahun
        if ($usia >= 24 AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
            $pcv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 4)
            ->get();
            if (empty($pcv1->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];;
                $kondisi['imunisasi'] = $im[3]->id; //pcv 1 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }

            return redirect()->route('kondisi.show', $baby_id);
        }
        //hepatitis A 
        if ($kondisi['travelling'] == "Ya" AND in_array("Pergi ke daerah endemis hepatitis A", $kondisiku)) {
            if ($usia >= 12) {
                $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 11)
                ->get();
                if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                    if ($kondisi['tgl_brkt']!= NULL) { //Hepa A 1 (mengisi tgl keberangkatan)
                        $tglbrkt = Carbon::parse($kondisi['tgl_brkt']);
                        $kondisi['tgl_rekom'] =  $tglbrkt->addDays(7);
                        $kondisi['imunisasi'] = $im[10]->id;
                        $kondisi->save();
                    }
                    else { //Hepa A 1 (tidak mengisi tgl keberangkatan)
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[10]->id;
                        $kondisi->save();
                    }
                }
            }   
        }
        //hepatitis A 2
        if ($usia >= 12 AND $kondisi['imunisasisblm'] == "Hepatitis A 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 12)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[11]->id;
                $kondisi->save();
            }
            $hepa1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 11)
            ->get();
            if (empty($hepa1->first())) {
                $kondisi33 = Kondisi::create($request->all());
                $kondisi33->baby_id = $baby_id; //baby id
                $kondisi33['tgl_rekom'] = $kondisi['tgl'];
                $kondisi33['imunisasi'] = $im[10]->id; //hepa a 1 sudah dilakukan
                $kondisi33->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi33->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        } 
        //hepatitis A complete
        if ($kondisi['imunisasisblm'] == "Hepatitis A 2") {
            $hepa2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 12)
            ->get();
            if (empty($hepa2->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[11]->id; //hepa a 2 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hepa1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 11)
            ->get();
            if (empty($hepa1->first())) {
                $kondisi8 = Kondisi::create($request->all());
                $kondisi8->baby_id = $baby_id; //baby id
                $kondisi8['tgl_rekom'] = $kondisi['tgl'];
                $kondisi8['imunisasi'] = $im[10]->id; //hepa a 1 sudah dilakukan
                $kondisi8->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi8->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //JE
        if ($kondisi['travelling'] == "Ya" AND $usia >= 9 AND in_array("Pergi atau tinggal di daerah endemis Japanesse Ensephalitis", $kondisiku)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 21)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi['tgl_brkt']!= NULL) {
                    $tglbrkt = Carbon::parse($kondisi['tgl_brkt']);
                    $kondisi['tgl_rekom'] =  $tglbrkt->addDays(7);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[20]->id;
                    $kondisi->save();
                }
                else {
                    $kondisi['tgl_rekom']  = $now->addDays(7);
                    $kondisi['imunisasi'] = $im[20]->id;
                    $kondisi->save();
                }  
            }
            
        }
        //JE 2
        if ($kondisi['imunisasisblm'] == "Japanesse Ensephalitis 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 22)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(12);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[21]->id;
                $kondisi->save();
            }
            $je1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 21)
            ->get();
            if (empty($je1->first())) {
                $kondisi34 = Kondisi::create($request->all());
                $kondisi34->baby_id = $baby_id; //baby id
                $kondisi34['tgl_rekom'] = $kondisi['tgl'];
                $kondisi34['imunisasi'] = $im[20]->id; //JE 1 sudah dilakukan
                $kondisi34->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi34->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }    
        //JE complete
        if ($kondisi['imunisasisblm'] == "Japanesse Ensephalitis 2") {
            $je2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 22)
            ->get();
            if (empty($je2->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[21]->id; //JE 2 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $je1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 21)
            ->get();
            if (empty($je1->first())) {
                $kondisi7 = Kondisi::create($request->all());
                $kondisi7->baby_id = $baby_id; //baby id
                $kondisi7['tgl_rekom'] = $kondisi['tgl'];
                $kondisi7['imunisasi'] = $im[20]->id; //JE 1 sudah dilakukan
                $kondisi7->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi7->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //hepatitis b
        if (in_array("Petugas fasilitas kesehatan", $kondisiku)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 23)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[22]->id;
                $kondisi->save();
            }   
        }
        //Hepatitis b 2
        if ($kondisi['imunisasisblm'] == "Hepatitis B 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 24)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[23]->id;
                $kondisi->save();
            }
            $hepb1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 23)
            ->get();
            if (empty($hepb1->first())) {
                $kondisi35 = Kondisi::create($request->all());
                $kondisi35->baby_id = $baby_id; //baby id
                $kondisi35['tgl_rekom'] = $kondisi['tgl'];
                $kondisi35['imunisasi'] = $im[22]->id; //hep b 1 sudah dilakukan
                $kondisi35->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi35->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        } 
        //Hepatitis b 3
        if ($kondisi['imunisasisblm'] == "Hepatitis B 2") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 25)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[24]->id;
                $kondisi->save();
            }
            $hepb1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 23)
            ->get();
            if (empty($hepb1->first())) {
                $kondisi36 = Kondisi::create($request->all());
                $kondisi36->baby_id = $baby_id; //baby id
                $kondisi36['tgl_rekom'] = $kondisi['tgl'];
                $kondisi36['imunisasi'] = $im[22]->id; //hep b 1 sudah dilakukan
                $kondisi36->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi36->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hepb2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 24)
            ->get();
            if (empty($hepb2->first())) {
                $kondisi37 = Kondisi::create($request->all());
                $kondisi37->baby_id = $baby_id; //baby id
                $kondisi37['tgl_rekom'] = $kondisi['tgl'];
                $kondisi37['imunisasi'] = $im[23]->id; //hep b 2 sudah dilakukan
                $kondisi37->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi37->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        } 
        //hepatitis b complete
        if ($kondisi['imunisasisblm'] == "Hepatitis B 3") {
            $hepb3 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 25)
            ->get();
            if (empty($hepb3->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[24]->id; //Hep B 3 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hepb2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 24)
            ->get();
            if (empty($hepb2->first())) {
                $kondisi9 = Kondisi::create($request->all());
                $kondisi9->baby_id = $baby_id; //baby id
                $kondisi9['tgl_rekom'] = $kondisi['tgl'];
                $kondisi9['imunisasi'] = $im[23]->id; //hep b 2 sudah dilakukan
                $kondisi9->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi9->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hepb1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 23)
            ->get();
            if (empty($hepb1->first())) {
                $kondisi11 = Kondisi::create($request->all());
                $kondisi11->baby_id = $baby_id; //baby id
                $kondisi11['tgl_rekom'] = $kondisi['tgl'];
                $kondisi11['imunisasi'] = $im[22]->id; //hep b 1 sudah dilakukan
                $kondisi11->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi11->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //dengue 1
        if ($usia <= 192 AND in_array("Pernah terkena penyakit demam berdarah", $kondisiku)) {
            if ($usia >= 108) {
                $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 26)
                ->get();
                if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                    if ($kondisi['tgl_rekom'] != NULL) {
                        $kondisi24 = Kondisi::create($request->all());
                        $kondisi24->baby_id = $baby_id; //baby id
                        $rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi24['tgl_rekom'] = $rekom->addMonth(1);
                        $kondisi24['imunisasi'] = $im[25]->id; 
                        $kondisi24->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi24->id,
                        ]);
                    }
                    else {
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[25]->id;
                        $kondisi->save();
                    }
                }
            }
            if ($usia < 108) {
                $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 26)
                ->get();
                if (empty($ada->first())) { //dijadwalkan saat anak berusia 108 bulan
                    $jadwaldbd = 108 - $usia;
                    $sekarang = Carbon::now();
                    $kondisi['tgl_rekom']  = $sekarang->addMonths($jadwaldbd);
                    $kondisi['imunisasi'] = $im[25]->id;
                    $kondisi->save();
                }  
            }     
        }
        //dengue 2
        if ($kondisi['imunisasisblm'] == "Demam Berdarah 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 27)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[26]->id;
                $kondisi->save();
            }
            $dbd1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 26)
            ->get();
            if (empty($dbd1->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi47 = Kondisi::create($request->all());
                $kondisi47->baby_id = $baby_id; //baby id
                $kondisi47['tgl_rekom'] = $kondisi['tgl'];
                $kondisi47['imunisasi'] = $im[25]->id; //DBD 1 sudah dilakukan
                $kondisi47->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi47->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        } 
        //dengue 3
        if ($kondisi['imunisasisblm'] == "Demam Berdarah 2") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 28)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[27]->id;
                $kondisi->save();
            }
            $dbd1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 26)
            ->get();
            if (empty($dbd1->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi32 = Kondisi::create($request->all());
                $kondisi32->baby_id = $baby_id; //baby id
                $kondisi32['tgl_rekom'] = $kondisi['tgl'];
                $kondisi32['imunisasi'] = $im[25]->id; //DBD 1 sudah dilakukan
                $kondisi32->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi32->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $dbd2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 27)
            ->get();
            if (empty($dbd2->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi48 = Kondisi::create($request->all());
                $kondisi48->baby_id = $baby_id; //baby id
                $kondisi48['tgl_rekom'] = $kondisi['tgl'];
                $kondisi48['imunisasi'] = $im[26]->id; //DBD 2 sudah dilakukan
                $kondisi48->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi48->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //dengue complete
        if ($kondisi['imunisasisblm'] == "Demam Berdarah 3") {
            $dbd3 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 28)
            ->get();
            if (empty($dbd3->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[27]->id; //DBD 3 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $dbd2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 27)
            ->get();
            if (empty($dbd2->first())) {
                $kondisi16 = Kondisi::create($request->all());
                $kondisi16->baby_id = $baby_id; //baby id
                $kondisi16['tgl_rekom'] = $kondisi['tgl'];
                $kondisi16['imunisasi'] = $im[26]->id; //DBD 2 sudah dilakukan
                $kondisi16->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi16->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $dbd1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 26)
            ->get();
            if (empty($dbd1->first())) {
                $kondisi17 = Kondisi::create($request->all());
                $kondisi17->baby_id = $baby_id; //baby id
                $kondisi17['tgl_rekom'] = $kondisi['tgl'];
                $kondisi17['imunisasi'] = $im[25]->id; //DBD 1 sudah dilakukan
                $kondisi17->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi17->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //HPV 1 9-14 th
        if ($baby->gender == "Perempuan" AND $usia <= 179) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 13)
                    ->get();
                if ($usia >= 108) {
                    if ($kondisi['tgl_rekom']!= NULL) {
                        if (empty($ada->first())) {
                            $kondisi6 = Kondisi::create($request->all());
                            $kondisi6->baby_id = $baby_id; //baby id
                            $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi

                            $rekom = Carbon::parse($kondisi['tgl_rekom']);
                            $kondisi6['tgl_rekom']  = $rekom->addMonths(1);
                            $kondisi6['imunisasi'] = $im[12]->id;
                            $kondisi6->save();
                            Jadwal::create([
                                'kondisi_id' => $kondisi6->id,
                            ]);
                        }
                    }
                    else {
                        if (empty($ada->first())) {
                            $sekarang = Carbon::now();
                            $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                            $kondisi['imunisasi'] = $im[12]->id;
                            $kondisi->save(); 
                        }
                    }
                    
                }
                if ($usia < 108) {
                    if (empty($ada->first())) {
                        $kondisi6 = Kondisi::create($request->all());
                        $kondisi6->baby_id = $baby_id; //baby id
                        $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi    
                        $jadwalhpv = (108 - $usia)+1;
                        $saatini = Carbon::now();
                        $kondisi6['tgl_rekom']  = $saatini->addMonths($jadwalhpv);
                        $kondisi6['imunisasi'] = $im[12]->id;
                        $kondisi6->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi6->id,
                        ]);
                    }
                }   
            }           
        }
        //HPV 2 9-14 tahun
        if (($baby->gender == "Perempuan" AND ($usia >= 108 AND $usia <= 179)) AND $kondisi['imunisasisblm'] == "HPV 1") {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 14)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[13]->id;
                $kondisi->save();
            }
            $hpv1done = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 13)
            ->get();
            if (empty($hpv1done->first())) {
                $kondisi25 = Kondisi::create($request->all());
                $kondisi25->baby_id = $baby_id; //baby id
                $kondisi25['tgl_rekom'] = $kondisi['tgl'];
                $kondisi25['imunisasi'] = $im[12]->id; //HPV 1 sudah dilakukan
                $kondisi25->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi25->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //HPV 1 bivalen/quad
        if ($baby->gender == "Perempuan" AND $usia >= 180) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 15)
                    ->get();
                    if ($kondisi['tgl_rekom']!= NULL) {
                        if (empty($ada->first())) {
                            $kondisi6 = Kondisi::create($request->all());
                            $kondisi6->baby_id = $baby_id; //baby id
                            $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi
                            //$kondisi6->usia = $now->diffInMonths($kondisi6->tgl_lahir); //hitung usia

                            $rekom = Carbon::parse($kondisi['tgl_rekom']);
                            $kondisi6['tgl_rekom']  = $rekom->addMonths(1);
                            $kondisi6['imunisasi'] = $im[14]->id;
                            $kondisi6->save();
                            Jadwal::create([
                                'kondisi_id' => $kondisi6->id,
                            ]);
                        }  
                    }
                    else {
                        if (empty($ada->first())) {
                            $kondisi['tgl_rekom']  = $now->addDays(7);
                            $kondisi['imunisasi'] = $im[14]->id;
                            $kondisi->save(); 
                        }
                    }
            }
        }
        //HPV 2 bi
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 1 Bivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 16)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[15]->id;
                $kondisi->save();
            }
            $hpv1bidone = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 15)
            ->get();
            if (empty($hpv1bidone->first())) {
                $kondisi26 = Kondisi::create($request->all());
                $kondisi26->baby_id = $baby_id; //baby id
                $kondisi26['tgl_rekom'] = $kondisi['tgl'];
                $kondisi26['imunisasi'] = $im[14]->id; //HPV 1 sudah dilakukan
                $kondisi26->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi26->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //HPV 3 bi
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 2 Bivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 17)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[16]->id;
                $kondisi->save();
            }
            $hpv2bidone = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 16)
            ->get();
            if (empty($hpv2bidone->first())) {
                $kondisi30 = Kondisi::create($request->all());
                $kondisi30->baby_id = $baby_id; //baby id
                $kondisi30['tgl_rekom'] = $kondisi['tgl'];
                $kondisi30['imunisasi'] = $im[15]->id; //HPV 2 sudah dilakukan
                $kondisi30->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi30->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hpv1bidone = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 15)
            ->get();
            if (empty($hpv1bidone->first())) {
                $kondisi31 = Kondisi::create($request->all());
                $kondisi31->baby_id = $baby_id; //baby id
                $kondisi31['tgl_rekom'] = $kondisi['tgl'];
                $kondisi31['imunisasi'] = $im[14]->id; //HPV 1 sudah dilakukan
                $kondisi31->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi31->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //HPV 2 quad
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 1 Quadrivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 19)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                $kondisi['imunisasi'] = $im[18]->id;
                $kondisi->save();
            }
            $hpv1qdone = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 18)
            ->get();
            if (empty($hpv1qdone->first())) {
                $kondisi27 = Kondisi::create($request->all());
                $kondisi27->baby_id = $baby_id; //baby id
                $kondisi27['tgl_rekom'] = $kondisi['tgl'];
                $kondisi27['imunisasi'] = $im[17]->id; //HPV 1 sudah dilakukan
                $kondisi27->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi27->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //HPV 3 quad
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 2 Quadrivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 20)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                $kondisi['imunisasi'] = $im[19]->id;
                $kondisi->save();
            }
            $hpv1qdone = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 18)
            ->get();
            if (empty($hpv1qdone->first())) {
                $kondisi28 = Kondisi::create($request->all());
                $kondisi28->baby_id = $baby_id; //baby id
                $kondisi28['tgl_rekom'] = $kondisi['tgl'];
                $kondisi28['imunisasi'] = $im[17]->id; //HPV 1 sudah dilakukan
                $kondisi28->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi28->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hpv2qdone = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 19)
            ->get();
            if (empty($hpv2qdone->first())) {
                $kondisi29 = Kondisi::create($request->all());
                $kondisi29->baby_id = $baby_id; //baby id
                $kondisi29['tgl_rekom'] = $kondisi['tgl'];
                $kondisi29['imunisasi'] = $im[18]->id; //HPV 2 sudah dilakukan
                $kondisi29->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi29->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //HPV 9-14 tahun complete
        if ($usia < 180 AND $kondisi['imunisasisblm'] == "HPV 2") {
            $hpv2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 14)
            ->get();
            if (empty($hpv2->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[13]->id; //HPV 2 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hpv1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 13)
            ->get();
            if (empty($hpv1->first())) {
                $kondisi18 = Kondisi::create($request->all());
                $kondisi18->baby_id = $baby_id; //baby id
                $kondisi18['tgl_rekom'] = $kondisi['tgl'];
                $kondisi18['imunisasi'] = $im[12]->id; //HPV 1 sudah dilakukan
                $kondisi18->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi18->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //HPV > 15 tahun complete
        if ($usia >= 180 AND ($kondisi['imunisasisblm'] == "HPV 3 Bivalen" OR $kondisi['imunisasisblm'] == "HPV 3 Quadrivalen")) {
            $hpv3bi = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 17)
            ->get();
            if (empty($hpv3bi->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[16]->id; //HPV 3 bi sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hpv2bi = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 16)
            ->get();
            if (empty($hpv2bi->first())) {
                $kondisi19 = Kondisi::create($request->all());
                $kondisi19->baby_id = $baby_id; //baby id
                $kondisi19['tgl_rekom'] = $kondisi['tgl'];
                $kondisi19['imunisasi'] = $im[15]->id; //HPV 2 sudah dilakukan
                $kondisi19->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi19->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $hpv1bi = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 15)
            ->get();
            if (empty($hpv1bi->first())) {
                $kondisi20 = Kondisi::create($request->all());
                $kondisi20->baby_id = $baby_id; //baby id
                $kondisi20['tgl_rekom'] = $kondisi['tgl'];
                $kondisi20['imunisasi'] = $im[14]->id; //HPV 1 sudah dilakukan
                $kondisi20->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi20->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //varisela 1
        if ($usia >= 12) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 7)
                    ->get();
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi2 = Kondisi::create($request->all());
                        $kondisi2->baby_id = $baby_id; //baby id
                        $kondisiku2 = json_decode($kondisi2->kondisi); //ubah ke array lagi
                        //$kondisi2->usia = $now->diffInMonths($kondisi2->tgl_lahir); //hitung usia
                        $sekarang = Carbon::now();
                        //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi2['tgl_rekom']  = $sekarang->addMonths(2);
                        $kondisi2['imunisasi'] = $im[6]->id;
                        $kondisi2->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi2->id,
                        ]);
                    }
                }
                else {
                    if (empty($ada->first())) {
                        $sekarang = Carbon::now();
                        $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                        $kondisi['imunisasi'] = $im[6]->id;
                        $kondisi->save();
                    }
                }
            }
        }
        //varisela 2 1-12 tahun
        if (($usia >= 12 AND $usia <= 155) AND $kondisi['imunisasisblm'] == "Varisela 1") {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 8)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[7]->id;
                $kondisi->save();
            }
            $var1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 7)
            ->get();
            if (empty($var1->first())) {
                $kondisi38 = Kondisi::create($request->all());
                $kondisi38->baby_id = $baby_id; //baby id
                $kondisi38['tgl_rekom'] = $kondisi['tgl'];
                $kondisi38['imunisasi'] = $im[6]->id; //Var 1 sudah dilakukan
                $kondisi38->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi38->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //varisela 2 >13 tahun
        if ($usia >= 156 AND $kondisi['imunisasisblm'] == "Varisela 1") {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 8)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[7]->id;
                $kondisi->save();
            }
            $var1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 7)
            ->get();
            if (empty($var1->first())) {
                $kondisi39 = Kondisi::create($request->all());
                $kondisi39->baby_id = $baby_id; //baby id
                $kondisi39['tgl_rekom'] = $kondisi['tgl'];
                $kondisi39['imunisasi'] = $im[6]->id; //Var 1 sudah dilakukan
                $kondisi39->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi39->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //varisela complete
        if ($kondisi['imunisasisblm'] == "Varisela 2") {
            $var2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 8)
            ->get();
            if (empty($var2->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[7]->id; //Var 2 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $var1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 7)
            ->get();
            if (empty($var1->first())) {
                $kondisi21 = Kondisi::create($request->all());
                $kondisi21->baby_id = $baby_id; //baby id
                $kondisi21['tgl_rekom'] = $kondisi['tgl'];
                $kondisi21['imunisasi'] = $im[6]->id; //Var 1 sudah dilakukan
                $kondisi21->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi21->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //tifoid
        if ($usia >= 24) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 9)
                    ->get();
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) { //jika belum pernah direkomendasikan
                        $kondisi3 = Kondisi::create($request->all());
                        $kondisi3->baby_id = $baby_id; //baby id
                        $kondisiku3 = json_decode($kondisi3->kondisi); //ubah ke array lagi
                        //$kondisi3->usia = $now->diffInMonths($kondisi3->tgl_lahir); //hitung usia
                        $sekarang = Carbon::now();
                        //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi3['tgl_rekom']  = $sekarang->addMonths(3); //was: addDays(67)
                        $kondisi3['imunisasi'] = $im[8]->id;
                        $kondisi3->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi3->id,
                        ]);
                    }
                }
                else {
                    if (empty($ada->first())) {
                        $sekarang = Carbon::now();
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[8]->id;
                        $kondisi->save();
                    }
                }
            }
        }
        //tifoid lanjutan
        if (($usia >= 24) AND $kondisi['imunisasisblm'] == "Tifoid Polisakarida") {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 10)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(36);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[9]->id;
                $kondisi->save();
            }
            $tif1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 9)
            ->get();
            if (empty($tif1->first())) {
                $kondisi40 = Kondisi::create($request->all());
                $kondisi40->baby_id = $baby_id; //baby id
                $kondisi40['tgl_rekom'] = $kondisi['tgl'];
                $kondisi40['imunisasi'] = $im[8]->id; //Var 1 sudah dilakukan
                $kondisi40->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi40->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //Tifoid complete
        if ($kondisi['imunisasisblm'] == "Tifoid Lanjutan") {
            $tif2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 10)
            ->get();
            if (empty($tif2->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[9]->id; //tif 2 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $tif1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 9)
            ->get();
            if (empty($tif1->first())) {
                $kondisi22 = Kondisi::create($request->all());
                $kondisi22->baby_id = $baby_id; //baby id
                $kondisi22['tgl_rekom'] = $kondisi['tgl'];
                $kondisi22['imunisasi'] = $im[8]->id; //tif 1 sudah dilakukan
                $kondisi22->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi22->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //influenza 6 bulan-8 th
        if ($usia >= 6 AND $usia <= 96) {
            if ($kondisi['imunisasisblm'] == NULL) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 29)
                ->get();
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi4 = Kondisi::create($request->all());
                        $kondisi4->baby_id = $baby_id; //baby id
                        $kondisiku4 = json_decode($kondisi4->kondisi); //ubah ke array lagi
                        $sekarang = Carbon::now();
                        //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi4['tgl_rekom']  = $sekarang->addMonth(4); //was: addDays(97)
                        $kondisi4['imunisasi'] = $im[28]->id;
                        $kondisi4->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi4->id,
                        ]);
                    }
                }
                else {
                    if (empty($ada->first())) {
                        $sekarang = Carbon::now();
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[28]->id;
                        $kondisi->save();
                    }
                }
            }  
        }
        //Influenza 2 < 9 th
        if ($usia < 108 AND $kondisi['imunisasisblm'] == "Influenza 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 30)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[29]->id;
                $kondisi->save();
            }
            $flu1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 29)
            ->get();
            if (empty($flu1->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi45 = Kondisi::create($request->all());
                $kondisi45->baby_id = $baby_id; //baby id
                $kondisi45['tgl_rekom'] = $kondisi['tgl'];
                $kondisi45['imunisasi'] = $im[28]->id; //flu 1 sudah dilakukan
                $kondisi45->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi45->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //influenza > 9 th
        if ($usia >= 108) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 29)
                    ->get();
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi4 = Kondisi::create($request->all());
                        $kondisi4->baby_id = $baby_id; //baby id
                        $kondisiku4 = json_decode($kondisi4->kondisi); //ubah ke array lagi
                        //$kondisi4->usia = $now->diffInMonths($kondisi4->tgl_lahir); //hitung usia
                        $sekarang = Carbon::now();
                        //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi4['tgl_rekom']  = $sekarang->addMonth(4); //was: addDays(97)
                        $kondisi4['imunisasi'] = $im[28]->id;
                        $kondisi4->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi4->id,
                        ]);
                    }
                }
                else {
                    if (empty($ada->first())) {
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[28]->id;
                        $kondisi->save();
                    }
                } 
            }
        }
        //Influenza 2 > 9 th
        if ($usia >= 108 AND $kondisi['imunisasisblm'] == "Influenza 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 30)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addYears(1);
                $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                if ( $lampau < 0) {
                    $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                }
                $kondisi['imunisasi'] = $im[29]->id;
                $kondisi->save();
            }
            $flu1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 29)
            ->get();
            if (empty($flu1->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                $kondisi46 = Kondisi::create($request->all());
                $kondisi46->baby_id = $baby_id; //baby id
                $kondisi46['tgl_rekom'] = $kondisi['tgl'];
                $kondisi46['imunisasi'] = $im[28]->id; //flu 1 sudah dilakukan
                $kondisi46->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi46->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //rotavirus 1
        if (($usia >= 2 AND $usia <= 5)) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 31)
                ->get();
            if ($kondisi['imunisasisblm'] == NULL) {
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi5 = Kondisi::create($request->all());
                        $kondisi5->baby_id = $baby_id; //baby id
                        $kondisiku5 = json_decode($kondisi5->kondisi); //ubah ke array lagi
                        //$kondisi5->$usia = $now->diffInMonths($kondisi5->tgl_lahir); //hitung $usia
                        $sekarang = Carbon::now();
                        //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi5['tgl_rekom']  = $sekarang->addDays(7);
                        $kondisi5['imunisasi'] = $im[30]->id;
                        $kondisi5->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi5->id,
                        ]);
                    }
                }
                else {
                    if (empty($ada->first())) {
                        $today = Carbon::now();
                        $kondisi['tgl_rekom']  = $today->addDays(7);
                        $kondisi['imunisasi'] = $im[30]->id;
                        $kondisi->save();
                    }
                }
            }
            //rotavirus 2
            if ($usia >= 5 AND $kondisi['imunisasisblm'] == "rotavirus 1") {
                $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 32)
                ->get();
                if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[31]->id;
                    $kondisi->save();
                }
                $rot1 = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 31)
                ->get();
                if (empty($rot1->first())) {
                    $kondisi41 = Kondisi::create($request->all());
                    $kondisi41->baby_id = $baby_id; //baby id
                    $kondisi41['tgl_rekom'] = $kondisi['tgl'];
                    $kondisi41['imunisasi'] = $im[30]->id; //rot 1 sudah dilakukan
                    $kondisi41->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi41->id,
                        'status' => "Sudah Dilakukan",
                        'tgl_pelaksanaan' => $kondisi->tgl,
                    ]);
                }
            }    
        }
        //rotavirus complete
        if ($kondisi['imunisasisblm'] == "Rotavirus 2") {
            $rot2 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 32)
            ->get();
            if (empty($rot2->first())) {
                $kondisi['tgl_rekom'] = $kondisi['tgl'];
                $kondisi['imunisasi'] = $im[31]->id; //Var 2 sudah dilakukan
                $kondisi->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            $rot1 = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 31)
            ->get();
            if (empty($rot1->first())) {
                $kondisi23 = Kondisi::create($request->all());
                $kondisi23->baby_id = $baby_id; //baby id
                $kondisi23['tgl_rekom'] = $kondisi['tgl'];
                $kondisi23['imunisasi'] = $im[30]->id; //rot 1 sudah dilakukan
                $kondisi23->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi23->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
            return redirect()->route('kondisi.show', $baby_id);
        }
        //influenza, varisela, tifoid jika belum cukup umur
        if ($usia < 24) {
            //tifoid
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 9)
                ->get();
            if (empty($ada->first())) { //jika belum pernah direkomendasikan
                $kondisi42 = Kondisi::create($request->all());
                $kondisi42->baby_id = $baby_id; //baby id   
                $jadwaltifoid = 24 - $usia;
                $saatini = Carbon::now();
                $kondisi42['tgl_rekom']  = $saatini->addMonths($jadwaltifoid);
                $kondisi42['imunisasi'] = $im[8]->id;
                $kondisi42->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi42->id,
                ]);
            }
            //varisela
            if ($usia < 12) {
                $adavar = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 7)
                ->get();
                if (empty($adavar->first())) { //jika belum pernah direkomendasikan
                    $kondisi43 = Kondisi::create($request->all());
                    $kondisi43->baby_id = $baby_id; //baby id   
                    $jadwalvarisela = 12 - $usia;
                    $saatini = Carbon::now();
                    $kondisi43['tgl_rekom']  = $saatini->addMonths($jadwalvarisela);
                    $kondisi43['imunisasi'] = $im[6]->id;
                    $kondisi43->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi43->id,
                    ]);
                }
                if ($usia < 6) {
                    $adaflu = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 29)
                    ->get();
                    if (empty($adaflu->first())) { //jika belum pernah direkomendasikan
                        $kondisi44 = Kondisi::create($request->all());
                        $kondisi44->baby_id = $baby_id; //baby id   
                        $jadwalinfluenza = 6 - $usia;
                        $saatini = Carbon::now();
                        $kondisi44['tgl_rekom']  = $saatini->addMonths($jadwalinfluenza);
                        $kondisi44['imunisasi'] = $im[28]->id;
                        $kondisi44->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi44->id,
                        ]);
                    }
                }
            }
        }
        
        //save semua create kondisi
        $kondisi->save();

        if ($kondisi['imunisasi'] == NULL) {
            return redirect()->back()->with('message','Tidak ada imunisasi khusus dan pilihan yang harus dijadwalkan.');
        }
    
        //hubungkan ke tabel jadwal
        Jadwal::create([
            'kondisi_id' => $kondisi->id,
        ]);
        
        return redirect()->route('kondisi.show', $baby_id);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
       
    }
}