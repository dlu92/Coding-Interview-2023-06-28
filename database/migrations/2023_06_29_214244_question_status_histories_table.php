<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_status_histories', function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            // Foreign keys
            $table->foreign('question_id')->references('id')->on('preguntas');
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
        Schema::dropIfExists('question_status_histories');
    }
}
