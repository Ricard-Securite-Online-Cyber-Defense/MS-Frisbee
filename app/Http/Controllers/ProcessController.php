<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Services\ProcessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /**
     * @var ProcessService
     */
    private $processService;

    /**
     * @param ProcessService $processService
     */
    public function __construct(ProcessService $processService)
    {
        $this->processService = $processService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->processService->getProcesses());
    }

    public function store(Request $request): JsonResponse
    {
        $process = $this->processService->createProcess($request->all());

        $this->processService->attachSteps($process, $request->get("steps"));

        return response()->json($this->processService->getProcesses());
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $process = Process::find($id);

        $process->update($request->all());

        $this->processService->attachSteps($process, $request->get("steps"));

        return response()->json($this->processService->getProcesses());
    }

    public function delete(int $id): JsonResponse
    {
        $process = Process::find($id);

        $process->delete();

        return response()->json($this->processService->getProcesses());
    }
}
