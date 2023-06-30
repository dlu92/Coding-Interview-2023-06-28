<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preguntas', function (Blueprint $table) {
            // Columns
            $table->increments('id')->change();
            $table->integer('status_id')->unsigned()->default(1)->after('id');

            // Foreign keys
            $table->foreign('status_id')->references('id')->on('question_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preguntas', function (Blueprint $table) {
            // Foreign keys
            $table->dropForeign(['status_id']);

            // Columns
            $table->id()->change();
            $table->dropColumn('status_id');
        });
    }
}
