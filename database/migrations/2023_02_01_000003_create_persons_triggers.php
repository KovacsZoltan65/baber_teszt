<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
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
        $procedure = "DROP TRIGGER IF EXISTS baber_teszt.persons_AFTER_INSERT;";
        $procedure .= "CREATE DEFINER=`root`@`localhost` TRIGGER baber_teszt.persons_AFTER_INSERT AFTER INSERT ON persons 
            FOR EACH ROW
            BEGIN
                # Kell futtatni a triggert?
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
      
                    INSERT INTO baber_teszt.persons_logs 
                    SELECT NULL, LOCALTIMESTAMP, 'I', p.* FROM persons p WHERE p.id = NEW.id;

                END IF;
            END;";
        
        $procedure .= "DROP TRIGGER IF EXISTS baber_teszt.persons_AFTER_UPDATE;";
        $procedure .= "CREATE DEFINER='root'@'localhost' TRIGGER baber_teszt.persons_AFTER_UPDATE AFTER UPDATE ON persons
            FOR EACH ROW
            BEGIN
                # Kell futtatni a triggert?
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                    SET @mod_op = 'U';
                    IF NEW.deleted_at IS NOT NULL THEN
                    SET @mod_op = 'D';
                    END IF;

                    INSERT INTO baber_teszt.persons_logs 
                    SELECT NULL, LOCALTIMESTAMP, @mod_op, p.* FROM persons p WHERE p.id = NEW.id;
                END IF;
            END;";
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baber_teszt.persons_AFTER_INSERT');
        Schema::dropIfExists('baber_teszt.persons_AFTER_UPDATE');
    }
};
