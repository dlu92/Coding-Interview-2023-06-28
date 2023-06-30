<?php

namespace App\Http\Services;

use App\Dto\Filters\TestFilterDto;
use App\Models\QuestionStatus;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

class TestService
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
     * List test
     * 
     * @param TestFilterDto $filters
     * @return Collection
     */
    public function getAll(TestFilterDto $filters): Collection
    {
        return Test::whereHas('questions', function($questions) use ($filters) {
                return $questions->whereHas('question', function($question) use ($filters) {
                    return $question->whereHas('blocks', function($blocks) use ($filters) {
                        return $blocks->where('bloqueID', '=', $filters->blockId)
                            ->where('oposicionID', '=', $filters->opositionId);
                    })
                    ->where('oposicionID', '=', $filters->opositionId)
                    ->where(function($query) use ($filters) {
                        return isset($filters->published) ?
                            $query->where('status_id', '=', QuestionStatus::PUBLISHED) : true;
                    });
                });
            })
            ->where('test_tipoID', '=', $filters->typeId)
            ->withCount(['questions as total_questions' => function($query) use ($filters){
                return $query->whereHas('question', function($question) use ($filters){
                    return isset($filters->published) ?
                        $question->where('status_id', '=', QuestionStatus::PUBLISHED) : true;
                });
            }])
            ->having('total_questions', '>', 5)
            ->get();
    }

}