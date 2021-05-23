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
use Auth;


class JadwalController extends Controller
{
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
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
    public function show($data)
    {
        $user = Imunisasi::query()
        ->where('nama', $data)
        ->get();

        return Inertia::render('imunisasi', ['data'=>$user]);
    }
}
