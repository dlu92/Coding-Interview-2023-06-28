<?php

namespace Database\Seeders;

use App\Models\QuestionStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AddQuestionStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key restriction
        Schema::disableForeignKeyConstraints();

        // Clear table
        QuestionStatus::truncate();

        $status = [
            QuestionStatus::PUBLISHED => QuestionStatus::PUBLISHED_ALIAS,
            QuestionStatus::EXPIRED   => QuestionStatus::EXPIRED_ALIAS,
            QuestionStatus::REPEALED  => QuestionStatus::REPEALED_ALIAS,
            QuestionStatus::OBSOLETE  => QuestionStatus::OBSOLETE_ALIAS,
        ];

        $data = collect();

        foreach ($status as $key => $value) {
            $data->push([
                'id'   => $key,
                'name' => $value,
            ]);
        }

        QuestionStatus::insert($data->toArray());
        
        Schema::enableForeignKeyConstraints();
    }
}
