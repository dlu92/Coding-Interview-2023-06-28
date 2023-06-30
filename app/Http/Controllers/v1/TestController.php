<?php

namespace App\Http\Controllers\v1;

use App\DTO\Filters\TestFilterDto;
use App\Http\Services\TestService;
use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;

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
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'oposition_id'  => 'required|integer|min:1',
            'test_id'       => 'required|integer|min:1',
            'block_id'      => 'required|integer|min:1',
        ]);

        $filters = new TestFilterDto([
            'opositionId'  => $request->oposition_id ?? null,
            'typeId'       => $request->test_id ?? null,
            'blockId'      => $request->block_id ?? null,
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

}