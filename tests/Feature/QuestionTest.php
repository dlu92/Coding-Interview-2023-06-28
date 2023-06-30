<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\QuestionStatus;
use App\Models\QuestionStatusHistory;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    /**
     * Test Question Update
     */
    public function testQuestionUpdate(): void
    {
        DB::beginTransaction();

        try {
            $testId     = 315264;
            $questionId = 11;
            $question   = Question::find($questionId);
            $response   = $this->json(
                'PUT',
                "/api/v2/tests/{$testId}/questions/{$questionId}",
                [
                    'status_id' => QuestionStatus::EXPIRED
                ],
                [
                    'content-type'  => 'application/json',
                    'accept'        => 'application/json',
                ])
                ->response;

            $response->assertJson([
                    'status' => 'success',
                    'data' => [
                        'id'        => $questionId,
                        'status_id' => QuestionStatus::EXPIRED,
                    ]
                ])
                ->assertStatus(200);

            $history = QuestionStatusHistory::where('question_id', $questionId)
                ->orderBy('id', 'desc')
                ->first();
                
            $this->assertEquals($question->status_id, $history->status_id);

            DB::rollback();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
