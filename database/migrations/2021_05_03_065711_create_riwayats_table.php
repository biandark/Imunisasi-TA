<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_penjadwalan')->nullable();
            $table->date('tgl_diberikan')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('baby_id');
            $table->foreign('baby_id')->references('id')->on('babies');
            $table->unsignedBigInteger('imunisasiwajib_id');
            $table->foreign('imunisasiwajib_id')->references('id')->on('imunisasiwajibs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayats');
    }
}
