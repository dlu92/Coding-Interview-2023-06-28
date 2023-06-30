<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TestTest extends TestCase
{
    /**
     * Test Correct Test
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
}
