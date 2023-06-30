<?php

namespace App\Services;

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
     * 
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


    /**
     * Correct test
     * 
     * @param array $questions
     * @param int $opositionID
     * @param int $blockID
     *  
     * @return array
     */
    public function correct(array $questions, int $opositionID, int $blockID): array
    {
        $nameResponses  = 'respuestas';
        $nameMarked     = 'marcado';
        $nameCorrect    = 'correcta';
        $nameAnswered   = 'contestada';
        $corrects       = 0;
        $incorrects     = 0;
        $noAnswers      = 0;

        foreach ($questions as $question) {
            $correct            = 1;
            $questionAnswered   = false;
            $responses          = $question[$nameResponses] ?? [];

            if(isset($question[$nameMarked]) && $blockID == 1 && $opositionID == 2){
                $numResponse        = count($responses);
                $marked             = $question[$nameMarked];
                $questionAnswered   = $marked == 1 || $marked == -1;
                $correct            = $numResponse < 0 || !$questionAnswered ? 0 : (
                    $marked == 1 ?
                        ($numResponse == 0 ? 1 : -1) :
                        ($numResponse == 0 ? -1 : 1)
                    );
            } else {
                foreach($responses as $response){
                    $correctAnswer      = $response[$nameCorrect] ?? false;
                    $answered           = $response[$nameAnswered] ?? false;
                    $questionAnswered   = $questionAnswered || $answered;
                    $correct            = $correct && $correctAnswer == $answered ? 1 : 0;
                }
            }

            $questionAnswered ? ($correct == 1 ? $corrects++ : $incorrects++) : $noAnswers++;
        }

        return [
            'corrects'      => $corrects,
            'incorrects'    => $incorrects,
            'noAnswers'     => $noAnswers,
        ];
    }

}