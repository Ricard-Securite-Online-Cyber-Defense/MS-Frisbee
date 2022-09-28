<?php

namespace App\Http\Controllers;

use App\Models\Frisbee;
use App\Services\FrisbeeService;
use App\Services\ProcessService;
use App\Services\RangeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrisbeeController extends Controller
{
    /**
     * @var FrisbeeService
     */
    private $frisbeeService;
    /**
     * @var ProcessService
     */
    private $processService;
    /**
     * @var RangeService
     */
    private $rangeService;

    /**
     * @param FrisbeeService $frisbeeService
     * @param ProcessService $processService
     * @param RangeService $rangeService
     */
    public function __construct(FrisbeeService $frisbeeService, ProcessService $processService, RangeService $rangeService)
    {
        $this->frisbeeService = $frisbeeService;
        $this->processService = $processService;
        $this->rangeService = $rangeService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->frisbeeService->getFrisbees());
    }

    public function store(Request $request): JsonResponse
    {
        $processId = $this->processService->createProcess($request->get('process'))->id;
        $rangeId = $this->rangeService->createRange($request->get('range'))->id;

        $frisbee = Frisbee::create(
            $request->merge(["process_id" => $processId, "range_id" => $rangeId])
                ->only('name', 'description', 'price', 'range_id', 'process_id')
        );

        $this->frisbeeService->attachIngredients($frisbee, $request->get("ingredients"));

        return response()->json($this->frisbeeService->getFrisbees());
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $frisbee = Frisbee::find($id);

        $processId = $this->processService->createProcess($request->get('process'))->id;
        $rangeId = $this->rangeService->createRange($request->get('range'))->id;

        $frisbee->update(
            $request->merge(["process_id" => $processId, "range_id" => $rangeId])
                ->only('name', 'description', 'price', 'range_id', 'process_id')
        );

        $this->frisbeeService->attachIngredients($frisbee, $request->get("ingredients"));

        return response()->json($this->frisbeeService->getFrisbees());
    }

    /**
     * @param int $frisbee
     * @return JsonResponse
     */
    public function delete(int $frisbee): JsonResponse
    {
        Frisbee::find($frisbee)->delete();

        return response()->json($this->frisbeeService->getFrisbees());
    }
}
