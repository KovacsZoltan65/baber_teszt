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
        Schema::create('logs', function (Blueprint $table) {
            $table->id()->comment('Rekord azonosító');
            
            $table->timestamp('mod_date')->comment('Módosítás dátuma');
            $table->enum('mod_op', ['I','U','SD','R','D'])->comment('Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete');
            
            $table->integer('p_id')->nullable()->comment('"persons" rekord azonosító');
            $table->string('teljes_nev', 255)->nullable()->comment('Teljes név');
            
            $table->string('email', 255)->nullable()->comment('Email cím');
            $table->string('ado_azonosito', 255)->nullable()->comment('Adó azonosító');
            $table->integer('egyeb_id')->nullable()->comment('Egyéb azonosító');
            
            $table->timestamp('belepes')->nullable()->comment('Belépés dátuma');
            $table->timestamp('kilepes')->nullable()->comment('Kilépés dátuma');
            
            //$table->timestamps();
            $table->timestamp('created_at')->nullable()->comment('Keletkezés dátuma');
            $table->timestamp('updated_at')->nullable()->comment('Módosítás dátuma');
            $table->timestamp('deleted_at')->nullable()->comment('Törlés dátuma');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
