<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\QuestionStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTest extends TestCase
{

    /**
     * Test Correct Test
     * @return void
     */
    public function testCorrectTest(): void
    {
        $testFile   = 'tests/TestExample.json';
        $test       = json_decode(Storage::get($testFile), true);
        $response   = $this->json(
            'POST',
            '/api/v1/tests/correct',
            $test,
            [
                'content-type'  => 'application/json',
                'accept'        => 'application/json',
            ])
            ->response;

        $response->assertJson([
                'status' => 'success',
                'data' => [
                    'correct'       => 21,
                    'no_answers'    => 0,
                    'incorrect'     => 79
                ]
            ])
            ->assertStatus(200);
    }

    /**
     * Test list of tests v1
     * @return void
     */
    public function testTestsListV1(): void
    {
        $response   = $this->json(
            'GET',
            '/api/v1/tests',
            [
                'oposition_id'  => 1,
                'test_id'       => 3,
                'block_id'      => 1,
            ],
            [
                'content-type'  => 'application/json',
                'accept'        => 'application/json',
            ])
            ->response;

        $response->assertJson([
                'status' => 'success',
                'data' => [
                    [
                        'id'                => 315264,
                        'total_questions'   => 10,
                    ],
                ]
            ]);
    }

    /**
     * Test list of tests v2
     * @return void
     */
    public function testTestsListV2(): void
    {
        DB::beginTransaction();

        try {
            $question               = Question::find(11);
            $question->status_id    = QuestionStatus::EXPIRED;

            $question->save();

            $response   = $this->json(
                'GET',
                '/api/v2/tests',
                [
                    'oposition_id'  => 1,
                    'test_id'       => 3,
                    'block_id'      => 1,
                ],
                [
                    'content-type'  => 'application/json',
                    'accept'        => 'application/json',
                ])
                ->response;
    
            $response->assertJson([
                    'status' => 'success',
                    'data' => [
                        [
                            'id'                => 315264,
                            'total_questions'   => 9,
                        ],
                    ]
                ]);

            DB::rollback();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
