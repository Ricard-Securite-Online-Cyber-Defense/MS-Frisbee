<?php

namespace App\Services;

use App\Models\Process;
use App\Models\Step;

class ProcessService
{
    public function getProcesses() {
        return Process::with("steps")->get();
    }

    public function createProcess($process) {
        return Process::firstOrCreate(
            ["name" => $process["name"]],
            $process,
        );
    }

    public function attachSteps(Process $process, array $steps) {
        $ids = [];
        foreach($steps as $step) {
            $ids[] = Step::firstOrCreate(
                ["name" => $step["name"]],
                $step
            )->id;
        }

        $process->steps()->detach();
        $process->steps()->attach($ids);
    }
}
