<?php

use App\Http\Controllers\FrisbeeController;
use App\Http\Controllers\ProcessController;
use App\Models\Ingredient;
use App\Models\Range;
use App\Models\Step;
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
    Route::get("/", [FrisbeeController::class, 'index']);
    Route::post("/", [FrisbeeController::class, 'store']);
    Route::put("/{frisbee}", [FrisbeeController::class, 'update']);
    Route::delete("/{frisbee}", [FrisbeeController::class, 'delete']);
});

Route::group(["prefix" => "/ingredient"], function() {
    Route::get("/", function () {
        return Ingredient::all();
    });
    Route::post("/", function (Request $request) {
        return Ingredient::firstOrCreate(
            ["name" => $request["name"]],
            $request->all()
        );
    });
    Route::put("/{id}", function (int $id) {
        $ingredient = Ingredient::where("id", $id)->firstOrFail();
        return $ingredient->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $ingredient = Ingredient::where("id", $id)->firstOrFail();
        return $ingredient->delete();
    });
});

Route::group(["prefix" => "/process"], function() {
    Route::get("/", [ProcessController::class, "index"]);
    Route::post("/", [ProcessController::class, "store"]);
    Route::put("/{process}", [ProcessController::class, "update"]);
    Route::delete("/{process}", [ProcessController::class, "delete"]);
});

Route::group(["prefix" => "/step"], function() {
    Route::get("/", function () {
        return Step::all();
    });
    Route::post("/", function (Request $request) {
        return Step::firstOrCreate(
            ["name" => $request["name"]],
            $request->all()
        );
    });
    Route::put("/{id}", function (int $id) {
        $step = Step::where("id", $id)->firstOrFail();
        return $step->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $step = Step::where("id", $id)->firstOrFail();
        return $step->delete();
    });
});

Route::group(["prefix" => "/range"], function() {
    Route::get("/", function () {
        return Range::all();
    });
});
