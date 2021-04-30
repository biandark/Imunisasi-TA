<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Kondisi;
use App\Models\Imunisasi;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;


class JadwalController extends Controller
{
    public function index() 
    {
        $users = DB::table('kondisis')
            ->join('imunisasis', 'kondisis.imunisasi', '=', 'imunisasis.id')
            ->join('jadwals', 'kondisis.id', '=', 'jadwals.kondisi_id')
            ->where('user_id', auth()->id())
            ->get();
        
        return Inertia::render('riwayat', ['data'=>$users]);
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

    public function update(Request $request)
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
