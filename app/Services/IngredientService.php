<?php

namespace App\Services;

use App\Models\Frisbee;
use App\Models\Ingredient;
use App\Models\Process;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class IngredientService
{
    public function createIngredient($range) {
        return Process::firstOrCreate(
            ["name" => $range["name"]],
            $range,
        );
    }
}
