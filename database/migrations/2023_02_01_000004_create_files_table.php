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
        Schema::create('files', function (Blueprint $table) {
            $table->id()->comment('Rekord azonosító');
            
            $table->string('name', 255)->index()->comment('Fájl neve');
            $table->string('file_path', 255)->index()->comment('Fájl helye');
            $table->timestamp('upload_date')->comment('Feltöltés ideje');
            
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
        Schema::dropIfExists('files');
    }
};
