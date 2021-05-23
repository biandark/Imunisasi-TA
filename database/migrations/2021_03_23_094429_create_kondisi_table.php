<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKondisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kondisis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('baby_id')->nullable();
            $table->foreign('baby_id')->references('id')->on('babies');
            $table->string('travelling');
            $table->text('kondisi')->nullable();
            $table->date('tgl_brkt')->nullable();
            $table->string('imunisasisblm')->nullable();
            $table->date('tgl')->nullable();
            $table->date('tgl_rekom')->nullable();
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kondisis');
    }
}
