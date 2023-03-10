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
        // "INSERT" művelet LOG -olása
        $procedure = "DROP TRIGGER IF EXISTS baber_teszt.files_AFTER_INSERT;";
        $procedure .= "CREATE DEFINER=`root`@`localhost` TRIGGER baber_teszt.files_AFTER_INSERT AFTER INSERT ON files 
            FOR EACH ROW
            BEGIN
                # Kell futtatni a triggert?
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
      
                    INSERT INTO baber_teszt.files_logs 
                    SELECT NULL, LOCALTIMESTAMP, 'I', f.* FROM files f WHERE f.id = NEW.id;

                END IF;
            END;";
        
        // "UPDATE" művelet LOG -olása
        $procedure .= "DROP TRIGGER IF EXISTS baber_teszt.files_AFTER_UPDATE;";
        $procedure .= "CREATE DEFINER='root'@'localhost' TRIGGER baber_teszt.files_AFTER_UPDATE AFTER UPDATE ON files
            FOR EACH ROW
            BEGIN
                # Kell futtatni a triggert?
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                    SET @mod_op = 'U';
                    IF NEW.deleted_at IS NOT NULL THEN
                    SET @mod_op = 'D';
                    END IF;

                    INSERT INTO baber_teszt.files_logs 
                    SELECT NULL, LOCALTIMESTAMP, @mod_op, f.* FROM files f WHERE f.id = NEW.id;
                END IF;
            END;";
        
        // "DELETE" művelet LOG -olása
        $procedure .= "DROP TRIGGER IF EXISTS baber_teszt.files_BEFORE_DELETE;";
        $procedure .= "CREATE DEFINER=`root`@`localhost` TRIGGER baber_teszt.files_BEFORE_DELETE BEFORE DELETE ON files 
            FOR EACH ROW
            BEGIN
                # Kell futtatni a triggert?
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN

                    INSERT INTO baber_teszt.persons_logs 
                    SELECT NULL, LOCALTIMESTAMP, 'D', f.* FROM files f WHERE f.id = OLD.id;

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
        Schema::dropIfExists('baber_teszt.files_AFTER_INSERT;');
        Schema::dropIfExists('baber_teszt.files_AFTER_UPDATE');
    }
};
