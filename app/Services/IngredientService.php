<?php

namespace App\Services;

use App\Models\Ingredient;

class IngredientService
{
    public function getIngredients() {
        return Ingredient::all();
    }

    public function createIngredient($ingredient) {
        return Ingredient::firstOrCreate(
            ["name" => $ingredient["name"]],
            $ingredient,
        );
    }
}
