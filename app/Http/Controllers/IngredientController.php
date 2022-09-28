<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Services\IngredientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * @var IngredientService
     */
    private $ingredientService;

    /**
     * @param IngredientService $ingredientService
     */
    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->ingredientService->getIngredients());
    }

    public function store(Request $request): JsonResponse
    {
        $this->ingredientService->createIngredient($request->all());

        return response()->json($this->ingredientService->getIngredients());
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $ingredient = Ingredient::find($id);

        $ingredient->update($request->all());

        return response()->json($this->ingredientService->getIngredients());
    }

    public function delete(int $id): JsonResponse
    {
        $ingredient = Ingredient::find($id);

        $ingredient->delete();

        return response()->json($this->ingredientService->getIngredients());
    }
}
