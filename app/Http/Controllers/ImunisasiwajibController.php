<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Imunisasiwajib;

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
        return Inertia::render('InfoImunisasiWajib', [
            'imunisasiwajibs' => $imunisasiwajibs,
        ]);
    }
}