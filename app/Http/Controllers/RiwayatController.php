<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Baby;
use App\Models\Riwayat;
use App\Models\Imunisasiwajib;
use Illuminate\Support\Arr;

class RiwayatController extends Controller
{
    public function __construct() 
    {
     $this->middleware('auth');
    }
    
    public function index($baby_id) {
        if (Baby::where('id', $baby_id)->first()->user_id != Auth::user()->id) {
            return redirect()->route('databayi');
        }

        $is_not_filled = empty(Riwayat::where('baby_id', $baby_id)->first());

        if ($is_not_filled) {
            return redirect()->route('form', ['baby_id' => $baby_id]);
        }
        $baby = Baby::where('id', $baby_id)->first();
        $riwayats = Riwayat::where('baby_id', $baby->id)->with('imunisasiwajib')
                        ->orderBy('imunisasiwajib_id','ASC')->get();

        return Inertia::render('RiwayatImunisasiWajib', [
            'baby' => $baby,
            'riwayats' => $riwayats,
        ]);
    }

    public function update($baby_id, Request $request)
    {
        Validator::make($request->all(), [
            'tgl_diberikan' => ['required'],
            'status' => ['required'],
        ])->validate();
    
        if ($request->has('id')) {
            Riwayat::find($request->input('id'))->update($request->all());
            //update baby atribut done
        }

        $baby = Baby::where('id', $baby_id)->first();

        $done = Riwayat::where('baby_id', $baby->id)
            ->where('status', 'Sudah')
            ->get(['imunisasiwajib_id'])->toArray();
        $done = Arr::flatten($done);
        $done = json_encode($done);

        $last_polio = Riwayat::where('baby_id', $baby->id)
            ->whereIn('imunisasiwajib_id',[2,4,6,8,10])
            ->where('status','Sudah')
            ->orderBy('imunisasiwajib_id','DESC')->first();
            if (!empty($last_polio)) {
                $last_polio = $last_polio->tgl_diberikan;
            }

        $last_dpt = Riwayat::where('baby_id', $baby->id)
            ->whereIn('imunisasiwajib_id',[5,7,9,12])
            ->where('status','Sudah')
            ->orderBy('imunisasiwajib_id','DESC')->first();
            if (!empty($last_dpt)) {
                $last_dpt = $last_dpt->tgl_diberikan;
            }

        $last_mr = Riwayat::where('baby_id', $baby->id)
            ->whereIn('imunisasiwajib_id',[11,13])
            ->where('status','Sudah')
            ->orderBy('imunisasiwajib_id','DESC')->first();
                if (!empty($last_mr)) {
                    $last_mr = $last_mr->tgl_diberikan;
                }
                
        app('App\Http\Controllers\BabyController')->rules($baby->id, $baby->ttl, $baby->bb, $done, $last_polio, $last_dpt, $last_mr);

        return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
    }
}
