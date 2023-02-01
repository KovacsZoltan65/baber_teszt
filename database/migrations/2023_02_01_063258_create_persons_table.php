<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id()->comment('Rekord azonosító');
            $table->string('teljes_nev', 255)->index()->comment('Teljes név');
            
            $table->string('email', 255)->unique()->index()->comment('Email cím');
            $table->string('ado_azonosito', 255)->unique()->index()->comment('Adó azonosító');
            $table->integer('egyeb_id')->unique()->index()->comment('Egyéb azonosító');
            
            $table->timestamp('belepes')->comment('Belépés dátuma');
            $table->timestamp('kilepes')->nullable()->comment('Kilépés dátuma');
            
            $table->timestamps();
            $table->softDeletes()->comment('Rekord törlésének dátuma');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
};
