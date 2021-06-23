<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNamaimunisasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imunisasis', function (Blueprint $table) {
            $table->renameColumn('nama', 'jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imunisasis', function (Blueprint $table) {
            $table->renameColumn('jenis', 'nama');
        });
    }
}
