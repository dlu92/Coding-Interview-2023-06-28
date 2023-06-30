<?php

use App\Models\QuestionStatus;
use Database\Seeders\AddQuestionStatusesSeeder;
use Illuminate\Database\Migrations\Migration;

class AddQuestionStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new AddQuestionStatusesSeeder)->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Clear table
        QuestionStatus::truncate();
    }
}
