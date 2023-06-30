<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class InitDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sqlFile = 'sql/db_template.sql';
        $sql = Storage::get($sqlFile);

        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = data_get($table, 'Tables_in_innotest');

            if($tableName != 'migrations'){
                Schema::dropIfExists($tableName);
            }
            
        }
    }
}
