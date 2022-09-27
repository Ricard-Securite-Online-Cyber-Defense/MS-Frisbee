<?php

use App\Models\Frisbee;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(["prefix" => "/frisbee"], function() {
    Route::get("/", function () {
        return Frisbee::with('ingredients')->get();
    });
    Route::post("/", function (Request $request) {
        $ingredients = [];
        foreach($request->get("ingredients") as $ingredient) {
            $ingredients[] = Ingredient::firstOrCreate($ingredient)->id;
        }
        $frisbee = Frisbee::create($request->only('name', 'description', 'price', 'range'));

        $frisbee->ingredients()->attach($ingredients);

        return $frisbee;
    });
    Route::patch("/{id}", function (int $id) {
        $frisbee = Frisbee::where("id", $id)->firstOrFail();
        return $frisbee->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $frisbee = Frisbee::where("id", $id)->firstOrFail();
        return $frisbee->delete();
    });
});


Route::group(["prefix" => "/ingredient"], function() {
    Route::get("/", function () {
        return Ingredient::all();
    });
    Route::post("/", function (Request $request) {
        $ingredients = [];
        foreach($request->get("ingredients") as $ingredient) {
            $ingredients[] = Ingredient::firstOrCreate($ingredient);
        }

        return $ingredients;
    });
    Route::patch("/{frisbee}", function (int $id) {
        $frisbee = Ingredient::where("id", $id)->firstOrFail();
        return $frisbee->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $frisbee = Ingredient::where("id", $id)->firstOrFail();
        return $frisbee->delete();
    });
});
