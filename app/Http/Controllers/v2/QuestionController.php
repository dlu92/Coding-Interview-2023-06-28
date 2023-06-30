<?php

namespace App\Http\Controllers\v2;

use App\DTO\Models\QuestionModelDto;
use App\Services\QuestionService;
use App\Models\QuestionStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class QuestionController extends Controller
{

    private $questionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * List question
     */
    public function index(Request $request)
    {
        $testId = $request->route('test_id');

        $questions = collect($this->questionService->getAll($testId)->toArray())
            ->map(function($test){
                $createdAt  = $test['created_at'] ?? null;
                $updatedAt  = $test['updated_at'] ?? null;

                if($createdAt){
                    $test['created_at'] = Carbon::parse($createdAt)->format('Y-m-d H:i');
                }

                if($updatedAt){
                    $test['updated_at'] = Carbon::parse($updatedAt)->format('Y-m-d H:i');

                }
                
                return $test;
            });

        return response()->json($questions);
    }

    /**
     * Update question
     */
    public function update(Request $request)
    {
        $statusAcepted = [
            QuestionStatus::PUBLISHED,
            QuestionStatus::EXPIRED,
            QuestionStatus::REPEALED,
            QuestionStatus::OBSOLETE,
        ];

        $this->validate($request, [
            'status_id'     => 'required|integer|in:'. implode(',', $statusAcepted),
        ]);

        $testId     = $request->route('test_id');
        $questionId = $request->route('question_id');
        $question   = new QuestionModelDto([
            'id'        => $questionId,
            'statusId'  => $request->status_id ?? null,
        ]);

        $question = collect($this->questionService->update($question, $testId));

        $createdAt  = $question['created_at'] ?? null;
        $updatedAt  = $question['updated_at'] ?? null;

        if($createdAt){
            $question['created_at'] = Carbon::parse($createdAt)->format('Y-m-d H:i');
        }

        if($updatedAt){
            $question['updated_at'] = Carbon::parse($updatedAt)->format('Y-m-d H:i');
        }

        return response()->json($question);

    }
}