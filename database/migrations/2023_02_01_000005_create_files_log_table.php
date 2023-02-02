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
        Schema::create('files_logs', function (Blueprint $table) {
            $table->id()->comment('Rekord azonosító');
            $table->timestamp('mod_date')->comment('Módosítás dátuma');
            $table->enum('mod_op', ['I','U','SD','R','D'])->comment('Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete');
            
            $table->integer('f_id')->nullable()->comment('"files" rekord azonosító');
            $table->string('name', 255)->nullable()->comment('Fájl neve');
            $table->string('file_path', 255)->comment('Fájl helye');
            $table->timestamp('upload_date')->nullable()->comment('Feltöltés ideje');
            
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
        Schema::dropIfExists('files_logs');
    }
};
