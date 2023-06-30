<?php

namespace App\Http\Services;

use App\DTO\Models\QuestionModelDto;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * List question
     * 
     * @return Collection
     */
    public function getAll(?int $testId = null): Collection
    {
        return Question::whereHas('tests', function($tests) use ($testId) {
                return $testId ? $tests->where('testID', $testId) : true;
            })->get();
    }
    
    /**
     * Update question
     * 
     * @param QuestionModelDto $question
     * @param int|null $testId
     * @return Question
     */
    public function update(QuestionModelDto $question, ?int $testId = null): Question
    {
        $model = Question::whereHas('tests', function($tests) use ($testId) {
                return $testId ? $tests->where('testID', $testId) : true;
            })
            ->findOrFail($question->id);
        
        $model->status_id = $question->statusId;
        $model->save();

        return $model;
    }

}