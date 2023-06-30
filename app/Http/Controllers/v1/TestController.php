<?php

namespace App\Http\Controllers\v1;

use App\DTO\Filters\TestFilterDto;
use App\Services\TestService;
use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{

    private $testService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * List test
     * 
     * @param Request $request
     * @return JsonResponse
     * 
     */
    public function index(Request $request): JsonResponse
    {
        $params = $this->validate($request, [
            'oposition_id'  => 'required|integer|min:1',
            'test_id'       => 'required|integer|min:1',
            'block_id'      => 'required|integer|min:1',
        ]);

        $filters = new TestFilterDto([
            'opositionId'  => $params['oposition_id'] ?? null,
            'typeId'       => $params['test_id'] ?? null,
            'blockId'      => $params['block_id'] ?? null,
        ]);

        $tests = collect($this->testService->getAll($filters)->toArray())
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

        return response()->json($tests);
    }

    /**
     * Correct test
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function correct(Request $request): JsonResponse
    {
        $params         = $this->validate($request, [
            'oposicionID'                           => 'required|integer|min:1',
            'bloqueID'                              => 'required|integer|min:1',
            'preguntas'                             => 'required|array',
            'preguntas.*.preguntaID'                => 'required|integer|min:1',
            'preguntas.*.marcado'                   => 'boolean',
            'preguntas.*.respuestas'                => 'required|array',
            'preguntas.*.respuestas.*.id'           => 'required|integer|min:1',
            'preguntas.*.respuestas.*.contestada'   => 'required|boolean',
            'preguntas.*.respuestas.*.correcta'     => 'required|boolean',
        ]);
        $questions      = $params['preguntas'] ?? [];
        $opositionID    = $params['oposicionID'] ?? null;
        $blockID        = $params['bloqueID'] ?? null;

        $correction = $this->testService->correct($questions, $opositionID, $blockID);

        return response()->json([
            'correct'       => $correction['corrects'],
            'no_answers'    => $correction['noAnswers'],
            'incorrect'     => $correction['incorrects'],
        ]);
    }

}