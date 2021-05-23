<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\EndemisController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\ImunisasiwajibController;
use App\Http\Controllers\RiwayatController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

//imunisasi pilihan
Route::resource('kondisi', KondisiController::class);
Route::get('/{baby_id}/kondisi', 'App\Http\Controllers\KondisiController@index')->name('kondisi');
Route::post('/{baby_id}/kondisi', 'App\Http\Controllers\KondisiController@store')->name('kondisi.store');
Route::get('/{baby_id}/output', 'App\Http\Controllers\KondisiController@show')->name('kondisi.show');

Route::get('/{baby_id}/riwayat', 'App\Http\Controllers\JadwalController@index')->name('riwayat');
Route::put('/{baby_id}/riwayat', 'App\Http\Controllers\JadwalController@update')->name('riwayat.update');

Route::get('imunisasi/{data}')->name('imunisasi')->uses('App\Http\Controllers\JadwalController@show');

Route::resource('endemis', EndemisController::class);
Route::get('/endemis', 'App\Http\Controllers\EndemisController@index')->name('endemis');
Route::get('/daftarimunisasi', 'App\Http\Controllers\EndemisController@list')->name('daftarimunisasi');

//imunisasi wajib
Route::get('/{baby_id}/form', 'App\Http\Controllers\BabyController@create')->name('form');
Route::post('/{baby_id}/form', 'App\Http\Controllers\BabyController@store')->name('form.store');
Route::get('/{baby_id}/hasil', 'App\Http\Controllers\BabyController@show')->name('form.show');

Route::get('/{baby_id}/riwayatwajib', 'App\Http\Controllers\RiwayatController@index')->name('riwayatwajib');
Route::put('/{baby_id}/riwayatwajib','App\Http\Controllers\RiwayatController@update')->name('riwayatwajib.update');

Route::get('/detail/{id}', 'App\Http\Controllers\ImunisasiwajibController@detail')->name('detail');
Route::get('/info', 'App\Http\Controllers\ImunisasiwajibController@info')->name('info');

Route::get('/databayi', 'App\Http\Controllers\BabyController@index')->name('databayi');
Route::get('/databayi/create', 'App\Http\Controllers\BabyController@createbaby')->name('databayi.create');
Route::post('/databayi/create', 'App\Http\Controllers\BabyController@storebaby')->name('databayi.store');

