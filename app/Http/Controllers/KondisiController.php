<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Kondisi;
use App\Models\Imunisasi;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
  
class KondisiController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Kondisi::all();
        return Inertia::render('kondisi', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
        return Inertia::render('kondisi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show($kondisi)
    {
        $now = Carbon::today();

        $user = DB::table('kondisis')
        ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
        ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
        ->where('user_id', auth()->id())
        ->where('kondisis.created_at', $now)
        ->get();

        return Inertia::render('output', ['data'=>$user]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = Validator::make($request->only(['tgl_lahir', 'gender', 'travelling']), [
            'tgl_lahir' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'travelling' => ['string'],
        ])->validate();
        
        $kondisi = Kondisi::create($request->all());
        //$kondisi2 = clone $kondisi;
        //$kondisi3 = clone $kondisi;
        //$kondisi4 = clone $kondisi;
        //$kondisi5 = clone $kondisi;

        $now = Carbon::now();
        $im = Imunisasi::get();
        
        $kondisi['user_id'] = auth()->id(); //user id
        $kondisiku = json_decode($kondisi['kondisi']); //ubah ke array lagi
        $kondisi['usia'] = $now->diffInMonths($kondisi['tgl_lahir']); //hitung usia
        
        //aturan
        
        //meningitis
        if ($kondisi['travelling'] == "Ya" AND in_array("Pergi ke daerah endemis meningitis", $kondisiku) ){
            $tglbrkt = Carbon::parse($kondisi['tgl_brkt']);
            $kondisi['tgl_rekom'] = $tglbrkt->subDays(15);
            $kondisi['imunisasi'] = $im[0]->id;
            $kondisi->save();
        }
        
        //yellow fever
        if ($kondisi['usia'] >= 9 AND $kondisi['travelling'] == "Ya" AND (in_array("Pergi ke daerah endemis yellow fever", $kondisiku) OR in_array("hamil", $kondisiku))) {
            $tglbrkt = Carbon::parse($kondisi['tgl_brkt']);
            $kondisi['tgl_rekom'] = $tglbrkt->subDays(10);
            $kondisi['imunisasi'] = $im[1]->id;
            $kondisi->save();
        }
        //rabies
        if (in_array("Memiliki hewan peliharaan (anjing, kucing, kera)", $kondisiku)) {
            $kondisi['tgl_rekom']  = $now->addDays(7);
            $kondisi['imunisasi'] = $im[2]->id;
            $kondisi->save();
        }
        //PCV
        if (in_array("Tinggal di lingkungan rokok, padat, panti", $kondisiku)) {
            //PCV 1 2-5 bulan, 7-5 tahun
            if ((($kondisi['usia'] >= 2 AND $kondisi['usia'] <= 5) OR ($kondisi['usia'] >= 7 AND $kondisi['usia'] <= 60)) AND $kondisi['imunisasisblm'] == NULL) {
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[3]->id;
                $kondisi->save();
            }
            //PCV 2 4 bulan, 12-23 bulan
            if (($kondisi['usia'] >= 2 AND $kondisi['usia'] <= 5) OR ($kondisi['usia'] >= 12 AND $kondisi['usia'] <= 23) AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $kondisi['imunisasi'] = $im[4]->id;
                $kondisi->save();
            }
            //PCV 2 7-12 bulan
            if (($kondisi['usia'] >= 7 AND $kondisi['usia'] <= 12) AND $kondisi['imunisasisblm'] == "Pneumokokus 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $kondisi['imunisasi'] = $im[4]->id;
                $kondisi->save();
            }
            //PCV 3 5-6 bulan
            if (($kondisi['usia'] >= 5 AND $kondisi['usia'] <= 6) AND $kondisi['imunisasisblm'] == "Pneumokokus 2") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
                $kondisi['imunisasi'] = $im[5]->id;
                $kondisi->save();
            }
            //pcv booster?
        }
        //hepatitis A (USIA CEK LAGI)
        if ($kondisi['travelling'] == "Ya" AND in_array("Pergi ke daerah endemis hepatitis A", $kondisiku)) {
            //Hepa A 1 (tidak mengisi tgl keberangkatan)
            if (($kondisi['usia'] >= 12) AND $kondisi['imunisasisblm'] == NULL) {
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[10]->id;
                $kondisi->save();
            }
            if (($kondisi['usia'] >= 12) AND $kondisi['imunisasisblm'] == "Hepatitis A 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(15);
                $kondisi['imunisasi'] = $im[11]->id;
                $kondisi->save();
            }    
        }
        //JE
        if ($kondisi['travelling'] == "Ya" AND $kondisi['usia'] >= 9 AND in_array("Pergi atau tinggal di daerah endemis Japanesse Ensephalitis", $kondisiku)) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[20]->id;
                $kondisi->save();
            }
            if ($kondisi['imunisasisblm'] == "Japanese Ensephalitis 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(12);
                $kondisi['imunisasi'] = $im[21]->id;
                $kondisi->save();
            }    
        }
        //hepatitis b
        if (in_array("Petugas fasilitas kesehatan", $kondisiku)) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[22]->id;
                $kondisi->save();
            }
            if ($kondisi['imunisasisblm'] == "Hepatitis B 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $kondisi['imunisasi'] = $im[23]->id;
                $kondisi->save();
            } 
            if ($kondisi['imunisasisblm'] == "Hepatitis B 2") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $kondisi['imunisasi'] = $im[24]->id;
                $kondisi->save();
            }    
        }
        //dengue
        if (($kondisi['usia'] >= 108 AND $kondisi['usia'] <= 192) AND in_array("Pernah terkena penyakit demam berdarah", $kondisiku)) {
            if ($kondisi['imunisasisblm'] == NULL) {
                $kondisi['tgl_rekom']  = $now->addDays(7);
                $kondisi['imunisasi'] = $im[25]->id;
                $kondisi->save();
            }
            if ($kondisi['imunisasisblm'] == "Demam Berdarah 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $kondisi['imunisasi'] = $im[26]->id;
                $kondisi->save();
            } 
            if ($kondisi['imunisasisblm'] == "Demam Berdarah 2") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
                $kondisi['imunisasi'] = $im[27]->id;
                $kondisi->save();
            }    
        }
        //HPV 1 9-14 th
        if (($kondisi['gender'] == "Perempuan" AND ($kondisi['usia'] >= 108 AND $kondisi['usia'] <= 179))) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 13)
                ->get();
            if ($kondisi['imunisasisblm'] == NULL) {
                if ($kondisi['tgl_rekom']!= NULL) {
                    if (empty($ada->first())) {
                        $kondisi6 = Kondisi::create($request->all());
                        $kondisi6->user_id = auth()->id(); //user id
                        $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi
                        $kondisi6->usia = $now->diffInMonths($kondisi6->tgl_lahir); //hitung usia

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
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[12]->id;
                        $kondisi->save(); 
                    }
                }
            }
                           
        }
        //HPV 2 9-14 tahun
        if (($kondisi['gender'] == "Perempuan" AND ($kondisi['usia'] >= 108 AND $kondisi['usia'] <= 179)) AND $kondisi['imunisasisblm'] == "HPV 1") {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
            //$max_imunisasi = $tglimun->addMonths(15);
            $kondisi['imunisasi'] = $im[13]->id;
            $kondisi->save();
        }
        //HPV 1 bivalen/quad
        if (($kondisi['gender'] == "Perempuan" AND $kondisi['usia'] >= 180 AND $kondisi['imunisasisblm'] == NULL)) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 15)
                ->get();
            if ($kondisi['imunisasisblm'] == NULL) {
                if ($kondisi['tgl_rekom']!= NULL) {
                    if (empty($ada->first())) {
                        $kondisi6 = Kondisi::create($request->all());
                        $kondisi6->user_id = auth()->id(); //user id
                        $kondisiku6 = json_decode($kondisi6->kondisi); //ubah ke array lagi
                        $kondisi6->usia = $now->diffInMonths($kondisi6->tgl_lahir); //hitung usia

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
        if (($kondisi['gender'] == "Perempuan" AND $kondisi['usia'] >= 180 AND $kondisi['imunisasisblm'] == "HPV 1 Bivalen")) {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
            $kondisi['imunisasi'] = $im[15]->id;
            $kondisi->save();
        }
        //HPV 3 bi
        if (($kondisi['gender'] == "Perempuan" AND $kondisi['usia'] >= 180 AND $kondisi['imunisasisblm'] == "HPV 2 Bivalen")) {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
            $kondisi['imunisasi'] = $im[16]->id;
            $kondisi->save();
        }
        //HPV 2 quad
        if (($kondisi['gender'] == "Perempuan" AND $kondisi['usia'] >= 180 AND $kondisi['imunisasisblm'] == "HPV 1 Quadrivalen")) {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
            $kondisi['imunisasi'] = $im[18]->id;
            $kondisi->save();
        }
        //HPV 3 quad
        if (($kondisi['gender'] == "Perempuan" AND $kondisi['usia'] >= 180 AND $kondisi['imunisasisblm'] == "HPV 2 Quadrivalen")) {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(6);
            $kondisi['imunisasi'] = $im[19]->id;
            $kondisi->save();
        }
        //varisela 1
        if ($kondisi['usia'] >= 12 AND $kondisi['imunisasisblm'] == NULL) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 7)
                ->get();
            if ($kondisi['tgl_rekom']!= NULL){
                if (empty($ada->first())) {
                    $kondisi2 = Kondisi::create($request->all());
                    $kondisi2->user_id = auth()->id(); //user id
                    $kondisiku2 = json_decode($kondisi2->kondisi); //ubah ke array lagi
                    $kondisi2->usia = $now->diffInMonths($kondisi2->tgl_lahir); //hitung usia

                    $rekom = Carbon::parse($kondisi['tgl_rekom']);
                    $kondisi2['tgl_rekom']  = $rekom->addMonths(2);
                    $kondisi2['imunisasi'] = $im[6]->id;
                    $kondisi2->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi2->id,
                    ]);
                }
            }
            else {
                if (empty($ada->first())) {
                    $kondisi['tgl_rekom']  = $now->addDays(7);
                    $kondisi['imunisasi'] = $im[6]->id;
                    $kondisi->save();
                }
            }
        }
        //varisela 2 1-12 tahun
        if (($kondisi['usia'] >= 12 AND $kondisi['usia'] <= 155) AND $kondisi['imunisasisblm'] == "Varisela 1") {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
            $kondisi['imunisasi'] = $im[7]->id;
            $kondisi->save();
        }
        //varisela 2 >13 tahun
        if ($kondisi['usia'] >= 156 AND $kondisi['imunisasisblm'] == "Varisela 1") {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(2);
            $kondisi['imunisasi'] = $im[7]->id;
            $kondisi->save();
        }
        //tifoid
        if (($kondisi['usia'] >= 24) AND $kondisi['imunisasisblm'] == NULL) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 9)
                ->get();
            if ($kondisi['tgl_rekom']!= NULL){
                if (empty($ada->first())) { //jika belum pernah direkomendasikan
                    $kondisi3 = Kondisi::create($request->all());
                    $kondisi3->user_id = auth()->id(); //user id
                    $kondisiku3 = json_decode($kondisi3->kondisi); //ubah ke array lagi
                    $kondisi3->usia = $now->diffInMonths($kondisi3->tgl_lahir); //hitung usia

                    $rekom = Carbon::parse($kondisi['tgl_rekom']);
                    $kondisi3['tgl_rekom']  = $rekom->addMonths(3); //was: addDays(67)
                    $kondisi3['imunisasi'] = $im[8]->id;
                    $kondisi3->save();
                    Jadwal::create([
                        'kondisi_id' => $kondisi3->id,
                    ]);
                }
            }
            else {
                if (empty($ada->first())) {
                    $kondisi['tgl_rekom']  = $now->addDays(7);
                    $kondisi['imunisasi'] = $im[8]->id;
                    $kondisi->save();
                }
            }
            
        }
        //tifoid lanjutan
        if (($kondisi['usia'] >= 24) AND $kondisi['imunisasisblm'] == "Tifoid Polisakarida") {
            $tglimun = Carbon::parse($kondisi['tgl']);
            $kondisi['tgl_rekom'] = $tglimun->addMonths(36);
            $kondisi['imunisasi'] = $im[9]->id;
            $kondisi->save();
        }
        //influenza 6 bulan-8 th
        if ($kondisi['usia'] >= 6 AND $kondisi['usia'] <= 96) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 29)
                ->get();
            if ($kondisi['imunisasisblm'] == NULL) {
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi4 = Kondisi::create($request->all());
                        $kondisi4->user_id = auth()->id(); //user id
                        $kondisiku4 = json_decode($kondisi4->kondisi); //ubah ke array lagi
                        $kondisi4->usia = $now->diffInMonths($kondisi4->tgl_lahir); //hitung usia
        
                        $rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi4['tgl_rekom']  = $rekom->addMonth(4); //was: addDays(97)
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
            if ($kondisi['imunisasisblm'] == "Influenza 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $kondisi['imunisasi'] = $im[29]->id;
                $kondisi->save();
            }  
        }
        //influenza > 9 th
        if ($kondisi['usia'] >= 108) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 29)
                ->get();
            if ($kondisi['imunisasisblm'] == NULL) {
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi4 = Kondisi::create($request->all());
                        $kondisi4->user_id = auth()->id(); //user id
                        $kondisiku4 = json_decode($kondisi4->kondisi); //ubah ke array lagi
                        $kondisi4->usia = $now->diffInMonths($kondisi4->tgl_lahir); //hitung usia
        
                        $rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi4['tgl_rekom']  = $rekom->addMonth(4); //was: addDays(97)
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
        //rotavirus 1
        if (($kondisi['usia'] >= 2 AND $kondisi['usia'] <= 5)) {
            $ada = DB::table('kondisis')
                ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
                ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
                ->where('user_id', auth()->id())
                ->where('imunisasis.id', 31)
                ->get();
            if ($kondisi['imunisasisblm'] == NULL) {
                if ($kondisi['tgl_rekom']!= NULL){
                    if (empty($ada->first())) {
                        $kondisi5 = Kondisi::create($request->all());
                        $kondisi5->user_id = auth()->id(); //user id
                        $kondisiku5 = json_decode($kondisi5->kondisi); //ubah ke array lagi
                        $kondisi5->usia = $now->diffInMonths($kondisi5->tgl_lahir); //hitung usia
        
                        $rekom = Carbon::parse($kondisi['tgl_rekom']);
                        $kondisi5['tgl_rekom']  = $rekom->addDays(30);
                        $kondisi5['imunisasi'] = $im[30]->id;
                        $kondisi5->save();
                        Jadwal::create([
                            'kondisi_id' => $kondisi5->id,
                        ]);
                    }
                }
                else {
                    if (empty($ada->first())) {
                        $kondisi['tgl_rekom']  = $now->addDays(7);
                        $kondisi['imunisasi'] = $im[30]->id;
                        $kondisi->save();
                    }
                }
            }
            //rotavirus 2
            if ($kondisi['usia'] >= 5 AND $kondisi['imunisasisblm'] == "rotavirus 1") {
                $tglimun = Carbon::parse($kondisi['tgl']);
                $kondisi['tgl_rekom'] = $tglimun->addMonths(1);
                $kondisi['imunisasi'] = $im[31]->id;
                $kondisi->save();
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
        
        return redirect()->route('kondisi.show', $kondisi);
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