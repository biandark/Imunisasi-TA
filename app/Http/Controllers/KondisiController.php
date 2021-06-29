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
    public function __construct() 
    {
     $this->middleware('auth');
    }
    
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
        //JE 2
        if ($kondisi['imunisasisblm'] == "Japanesse Ensephalitis 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 22)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi52 = Kondisi::create($request->all());
                    $kondisi52->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi52['tgl_rekom'] = $tglrekom->addMonths(12);
                    $lampau = $now->diffInDays($kondisi52['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi52['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi52['imunisasi'] = $im[21]->id;
                    $kondisi52->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi52->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(12);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[21]->id;
                    $kondisi->save();
                }
                
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
            return redirect()->back()->with('message', 'Imunisasi Japanese Ensephalitis anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi53 = Kondisi::create($request->all());
                    $kondisi53->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi53['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi53['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi53['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi53['imunisasi'] = $im[11]->id;
                    $kondisi53->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi53->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[11]->id;
                    $kondisi->save();
                }
                
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
            return redirect()->back()->with('message', 'Imunisasi Hepatitis A sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi50 = Kondisi::create($request->all());
                    $kondisi50->baby_id = $baby_id;
                    $sekarang = Carbon::now();
                    $kondisi50['tgl_rekom'] = $sekarang->addDays(30);
                    $kondisi50['imunisasi'] = $im[2]->id;
                    $kondisi50->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi50->id,
                    ]);
                }
                else {
                    $sekarang = Carbon::now();
                    $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                    $kondisi['imunisasi'] = $im[2]->id;
                    $kondisi->save();
                }
            }
            
        }
        //PCV 3 5-6 bulan
        if ( $usia <= 6 AND $kondisi['imunisasisblm'] == "Pneumokokus 2") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 6)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi56 = Kondisi::create($request->all());
                    $kondisi56->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi56['tgl_rekom'] = $tglrekom->addMonths(2);
                    $lampau = $now->diffInDays($kondisi56['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi56['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi56['imunisasi'] = $im[5]->id;
                    $kondisi56->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi56->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[5]->id; //pcv 3
                    $kondisi->save();
                }
                
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
        //PCV 2 7-12 bulan
        if (($usia >= 7 AND $usia <= 12) AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi55 = Kondisi::create($request->all());
                    $kondisi55->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi55['tgl_rekom'] = $tglrekom->addMonths(1);
                    $lampau = $now->diffInDays($kondisi55['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi55['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi55['imunisasi'] = $im[4]->id;
                    $kondisi55->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi55->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[4]->id;
                    $kondisi->save();
                }
                
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
        //PCV 2 2-5 bulan, 12-23 bulan
        if ((($usia >= 2 AND $usia <= 5) OR ($usia >= 12 AND $usia <= 23)) AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 5)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi54 = Kondisi::create($request->all());
                    $kondisi54->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi54['tgl_rekom'] = $tglrekom->addMonths(2);
                    $lampau = $now->diffInDays($kondisi54['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi54['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi54['imunisasi'] = $im[4]->id;
                    $kondisi54->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi54->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[4]->id; //pcv 2
                    $kondisi->save();
                }
                
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
                        $sekarang = Carbon::now();
                        $kondisi49['tgl_rekom'] = $sekarang->addDays(30);
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

            return redirect()->back()->with('message', 'Imunisasi PCV anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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

            return redirect()->back()->with('message', 'Imunisasi PCV anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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

            return redirect()->back()->with('message', 'Imunisasi PCV anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi57 = Kondisi::create($request->all());
                    $kondisi57->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi57['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi57['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi57['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi57['imunisasi'] = $im[24]->id;
                    $kondisi57->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi57->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[24]->id;
                    $kondisi->save();
                }
                
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
        //Hepatitis b 2
        if ($kondisi['imunisasisblm'] == "Hepatitis B 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 24)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi58 = Kondisi::create($request->all());
                    $kondisi58->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi58['tgl_rekom'] = $tglrekom->addMonths(1);
                    $lampau = $now->diffInDays($kondisi58['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi58['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi58['imunisasi'] = $im[23]->id;
                    $kondisi58->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi58->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[23]->id;
                    $kondisi->save();
                }
                
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
        //hepatitis b
        if (in_array("Petugas fasilitas kesehatan", $kondisiku)) {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 23)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi51 = Kondisi::create($request->all());
                    $kondisi51->baby_id = $baby_id;
                    $sekarang = Carbon::now();
                    $kondisi51['tgl_rekom'] = $sekarang->addDays(30);
                    $kondisi51['imunisasi'] = $im[22]->id;
                    $kondisi51->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi51->id,
                    ]);
                }
                else {
                    $sekarang = Carbon::now();
                    $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                    $kondisi['imunisasi'] = $im[22]->id;
                    $kondisi->save();
                }
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
            return redirect()->back()->with('message', 'Imunisasi Hepatitis B sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi59 = Kondisi::create($request->all());
                    $kondisi59->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi59['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi59['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi59['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi59['imunisasi'] = $im[27]->id;
                    $kondisi59->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi59->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[27]->id;
                    $kondisi->save();
                }
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
        //dengue 2
        if ($kondisi['imunisasisblm'] == "Demam Berdarah 1") {
            $ada = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('baby_id', $baby_id)
            ->where('imunisasis.id', 27)
            ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi60 = Kondisi::create($request->all());
                    $kondisi60->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi60['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi60['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi60['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi60['imunisasi'] = $im[26]->id;
                    $kondisi60->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi60->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[26]->id;
                    $kondisi->save();
                }
                
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
                        $kondisi24->baby_id = $baby_id;
                        $sekarang = Carbon::now();
                        $kondisi24['tgl_rekom'] = $sekarang->addMonth(1);
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
                    if ($kondisi['tgl_rekom'] != NULL) {
                        $kondisi72 = Kondisi::create($request->all());
                        $kondisi72->baby_id = $baby_id; //baby id
                        $kondisi72['tgl_rekom'] = $sekarang->addMonths($jadwaldbd);
                        $kondisi72['imunisasi'] = $im[25]->id; 
                        $kondisi72->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi72->id,
                        ]);
                    }
                    else {
                        $kondisi['tgl_rekom']  = $sekarang->addMonths($jadwaldbd);
                        $kondisi['imunisasi'] = $im[25]->id;
                        $kondisi->save();
                    }
                }  
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
            return redirect()->back()->with('message', 'Imunisasi demam berdarah anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi61 = Kondisi::create($request->all());
                    $kondisi61->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi61['tgl_rekom'] = $tglrekom->addMonths(1);
                    $lampau = $now->diffInDays($kondisi61['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi61['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi61['imunisasi'] = $im[29]->id;
                    $kondisi61->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi61->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[29]->id;
                    $kondisi->save();
                }   
                
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
        //influenza 6 bulan-8 th
        if ($usia >= 6 AND $usia <= 96) {
            
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 29)
                ->get();
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        if ($kondisi['imunisasi'] != 29) {
                            $kondisi4 = Kondisi::create($request->all());
                            $kondisi4->baby_id = $baby_id; //baby id
                            $kondisiku4 = json_decode($kondisi4->kondisi); //ubah ke array lagi
                            $sekarang = Carbon::now();
                            //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                            $kondisi4['tgl_rekom']  = $sekarang->addMonth(1); //was: addDays(97)
                            $kondisi4['imunisasi'] = $im[28]->id;
                            $kondisi4->save();
                            Jadwal::create([
                                'kondisi_id' => $kondisi4->id,
                            ]);
                        }
                    }
                }
                else {
                    if (empty($ada->first())) {
                        if ($kondisi['imunisasi'] != 29) {
                            $sekarang = Carbon::now();
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi62 = Kondisi::create($request->all());
                    $kondisi62->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi62['tgl_rekom'] = $tglrekom->addYears(1);
                    $lampau = $now->diffInDays($kondisi62['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi62['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi62['imunisasi'] = $im[29]->id;
                    $kondisi62->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi62->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addYears(1);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[29]->id;
                    $kondisi->save();
                }
                
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
        //influenza > 9 th
        if ($usia >= 108) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 29)
                ->get();
            if ($kondisi['tgl_rekom']!= NULL){
                if (empty($ada->first())) {
                    if ($kondisi['imunisasi'] != 29) {
                        $kondisi4 = Kondisi::create($request->all());
                        $kondisi4->baby_id = $baby_id; //baby id
                        $kondisiku4 = json_decode($kondisi4->kondisi); //ubah ke array lagi
                        //$kondisi4->usia = $now->diffInMonths($kondisi4->tgl_lahir); //hitung usia
                        $sekarang = Carbon::now();
                        //$rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi4['tgl_rekom']  = $sekarang->addMonth(1); //was: addDays(97)
                        $kondisi4['imunisasi'] = $im[28]->id;
                        $kondisi4->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi4->id,
                        ]);
                    }
                }
            }
            else {
                if (empty($ada->first())) {
                    if ($kondisi['imunisasi'] != 29) {
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[28]->id;
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi63 = Kondisi::create($request->all());
                    $kondisi63->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi63['tgl_rekom'] = $tglrekom->addMonths(2);
                    $lampau = $now->diffInDays($kondisi63['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi63['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi63['imunisasi'] = $im[7]->id;
                    $kondisi63->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi63->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[7]->id;
                    $kondisi->save();
                }
                
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi64 = Kondisi::create($request->all());
                    $kondisi64->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi64['tgl_rekom'] = $tglrekom->addMonths(2);
                    $lampau = $now->diffInDays($kondisi64['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi64['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi64['imunisasi'] = $im[7]->id;
                    $kondisi64->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi64->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[7]->id;
                    $kondisi->save();
                }
               
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
        //varisela 1
        if ($usia >= 12) {
            
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 7)
                    ->get();
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        if ($kondisi['imunisasi'] != 7) {
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
                }
                else {
                    if (empty($ada->first())) {
                        if ($kondisi['imunisasi'] != 7) {
                            $sekarang = Carbon::now();
                            $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                            $kondisi['imunisasi'] = $im[6]->id;
                            $kondisi->save();
                        }
                    }
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
            return redirect()->back()->with('message', 'Imunisasi Varisela anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi65 = Kondisi::create($request->all());
                    $kondisi65->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi65['tgl_rekom'] = $tglrekom->addMonths(36);
                    $lampau = $now->diffInDays($kondisi65['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi65['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi65['imunisasi'] = $im[9]->id;
                    $kondisi65->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi65->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(36);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[9]->id;
                    $kondisi->save();
                }
                
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
                $kondisi40['imunisasi'] = $im[8]->id; //tif 1 sudah dilakukan
                $kondisi40->save();
                Jadwal::create([
                    'kondisi_id' => $kondisi40->id,
                    'status' => "Sudah Dilakukan",
                    'tgl_pelaksanaan' => $kondisi->tgl,
                ]);
            }
        }
        //tifoid
        if ($usia >= 24) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 9)
                ->get();
            if ($kondisi['tgl_rekom']!= NULL){
                if (empty($ada->first())) { //jika belum pernah direkomendasikan
                    if ($kondisi['imunisasi'] != 9) {
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
            }
            else {
                if (empty($ada->first())) {
                    if ($kondisi['imunisasi'] != 9) {
                        $sekarang = Carbon::now();
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[8]->id;
                        $kondisi->save();
                    }
                }
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
            return redirect()->back()->with('message', 'Imunisasi Tifoid anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi66 = Kondisi::create($request->all());
                    $kondisi66->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi66['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi66['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi66['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi66['imunisasi'] = $im[13]->id;
                    $kondisi66->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi66->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[13]->id;
                    $kondisi->save();
                }
               
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
        //HPV 1 9-14 th
        if ($baby->gender == "Perempuan" AND $usia <= 179) {
            
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 13)
                    ->get();
                if ($usia >= 108) {
                    if ($kondisi['tgl_rekom']!= NULL) {
                        if (empty($ada->first())) {
                            if ($kondisi['imunisasi'] != 14) {
                                $kondisi6 = Kondisi::create($request->all());
                                $kondisi6->baby_id = $baby_id; //baby id
                                $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi
                                $sekarang = Carbon::now();
                                $kondisi6['tgl_rekom']  = $sekarang->addMonths(4);
                                $kondisi6['imunisasi'] = $im[12]->id;
                                $kondisi6->save();
                                Jadwal::create([
                                    'kondisi_id' => $kondisi6->id,
                                ]);
                            }
                        }
                    }
                    else {
                        if (empty($ada->first())) {
                            if ($kondisi['imunisasi'] != 14) {
                                $sekarang = Carbon::now();
                                $kondisi['tgl_rekom']  = $sekarang->addDays(7);
                                $kondisi['imunisasi'] = $im[12]->id;
                                $kondisi->save();
                            } 
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
        //HPV 3 bi
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 2 Bivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 17)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi67 = Kondisi::create($request->all());
                    $kondisi67->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi67['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi67['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi67['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi67['imunisasi'] = $im[16]->id;
                    $kondisi67->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi67->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[16]->id;
                    $kondisi->save();
                }
               
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
        //HPV 2 bi
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 1 Bivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 16)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi68 = Kondisi::create($request->all());
                    $kondisi68->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi68['tgl_rekom'] = $tglrekom->addMonths(1);
                    $lampau = $now->diffInDays($kondisi68['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi68['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi68['imunisasi'] = $im[15]->id;
                    $kondisi68->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi68->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi['imunisasi'] = $im[15]->id;
                    $kondisi->save();
                }
               
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
        //HPV 3 quad
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 2 Quadrivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 20)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi69 = Kondisi::create($request->all());
                    $kondisi69->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi69['tgl_rekom'] = $tglrekom->addMonths(6);
                    $lampau = $now->diffInDays($kondisi69['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi69['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi69['imunisasi'] = $im[19]->id;
                    $kondisi69->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi69->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                        if ( $lampau < 0) {
                            $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                        }
                    $kondisi['imunisasi'] = $im[19]->id;
                    $kondisi->save();
                }
               
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
        //HPV 2 quad
        if (($baby->gender == "Perempuan" AND $usia >= 180 AND $kondisi['imunisasisblm'] == "HPV 1 Quadrivalen")) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 19)
                ->get();
            if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                if ($kondisi["tgl_rekom"] != NULL) {
                    $kondisi70 = Kondisi::create($request->all());
                    $kondisi70->baby_id = $baby_id; //baby id
                    $tglrekom = Carbon::parse($kondisi['tgl']);
                    $kondisi70['tgl_rekom'] = $tglrekom->addMonths(2);
                    $lampau = $now->diffInDays($kondisi70['tgl_rekom'], false);
                    if ( $lampau < 0) {
                        $kondisi70['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                    }
                    $kondisi70['imunisasi'] = $im[18]->id;
                    $kondisi70->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi70->id,
                    ]);
                }
                else {
                    $tglimun = Carbon::parse($kondisi['tgl']);
                    $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                    $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                        if ( $lampau < 0) {
                            $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                        }
                    $kondisi['imunisasi'] = $im[18]->id;
                    $kondisi->save();
                }
               
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
        //HPV 1 bivalen/quad
        if ($baby->gender == "Perempuan" AND $usia >= 180) {
            
                $ada = DB::table('kondisis')
                    ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                    ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                    ->where('baby_id', $baby_id)
                    ->where('imunisasis.id', 15)
                    ->orWhere('imunisasis.id', 16)
                    ->orWhere('imunisasis.id', 17)
                    ->get();
                    if ($kondisi['tgl_rekom']!= NULL) {
                        if (empty($ada->first())) {
                            $kondisi6 = Kondisi::create($request->all());
                            $kondisi6->baby_id = $baby_id; //baby id
                            $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi
                            $sekarang = Carbon::now();
                            $kondisi6['tgl_rekom']  = $sekarang->addMonths(4);
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
            return redirect()->back()->with('message', 'Imunisasi HPV sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
            return redirect()->back()->with('message', 'Imunisasi HPV sudah lengkap. Silahkan submit form kembali ika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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
            if ($usia <= 6 AND $kondisi['imunisasisblm'] == "Rotavirus 1") {
                $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('baby_id', $baby_id)
                ->where('imunisasis.id', 32)
                ->get();
                if (empty($ada->first())) { //hanya dijalankan jika imunisasi belum pernah dijadwalkan
                    if ($kondisi["tgl_rekom"] != NULL) {
                        $kondisi71 = Kondisi::create($request->all());
                        $kondisi71->baby_id = $baby_id; //baby id
                        $tglrekom = Carbon::parse($kondisi['tgl']);
                        $kondisi71['tgl_rekom'] = $tglrekom->addMonths(1);
                        $lampau = $now->diffInDays($kondisi71['tgl_rekom'], false);
                        if ( $lampau < 0) {
                            $kondisi71['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                        }
                        $kondisi71['imunisasi'] = $im[31]->id;
                        $kondisi71->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi71->id,
                        ]);
                    }
                    else {
                        $tglimun = Carbon::parse($kondisi['tgl']);
                        $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                        $lampau = $now->diffInDays($kondisi['tgl_rekom'], false);
                        if ( $lampau < 0) {
                            $kondisi['tgl_rekom'] = $now->addDays(7); //default untuk imunisasi yang terlewat jadwal
                        }
                        $kondisi['imunisasi'] = $im[31]->id;
                        $kondisi->save();
                    }
                   
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
            return redirect()->back()->with('message', 'Imunisasi Rotavirus anak sudah lengkap. Silahkan submit form kembali jika ingin mengetahui jenis imunisasi lain yang direkomendasikan.');
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