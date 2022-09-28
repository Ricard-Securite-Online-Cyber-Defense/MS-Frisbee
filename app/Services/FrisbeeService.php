<?php

namespace App\Services;

use App\Models\Frisbee;
use App\Models\Step;

class FrisbeeService
{
    /**
     * @var IngredientService
     */
    private $ingredientService;

    public function __construct(IngredientService $ingredientService) {

        $this->ingredientService = $ingredientService;
    }

    public function getFrisbees() {
        return Frisbee::with('ingredients')
            ->with('process')
            ->with('range')
            ->get();
    }

    public function getFrisbeeById(int $id) {
        return Frisbee::where('id', $id)
            ->with('ingredients')
            ->with('process')
            ->with('range')
            ->first();
    }

    public function attachIngredients(Frisbee $frisbee, array $ingredients) {
        $ids = [];
        foreach($ingredients as $ingredient) {
            $ids[] = Step::firstOrCreate(
                ["name" => $ingredient["name"]],
                $ingredient
            )->id;
        }

        logger($ids);

        $frisbee->ingredients()->detach();
        $frisbee->ingredients()->attach($ids);
    }
}
