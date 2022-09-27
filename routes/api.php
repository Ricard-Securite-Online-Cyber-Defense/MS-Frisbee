<?php

use App\Models\Frisbee;
use App\Models\Ingredient;
use App\Models\Process;
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
    Route::get("/", function () {
        return Frisbee::with('ingredients')
            ->with('process')
            ->with('range')
            ->get();
    });
    Route::post("/", function (Request $request) {
        $ingredients = [];
        foreach($request->get("ingredients") as $ingredient) {
            $ingredients[] = Ingredient::firstOrCreate(
                ["name" => $ingredient["name"]],
                $ingredient
            )->id;
        }

        $processId = Process::firstOrCreate(
            ["name" => $request->get("process")["name"]],
            $request->get("process"),
        )->id;

        $rangeId = Range::firstOrCreate(
            ["name" => $request->get("range")["name"]],
            $request->get("range"),
        )->id;

        $frisbee = Frisbee::create(
            $request->merge(["process_id" => $processId, "range_id" => $rangeId])
                ->only('name', 'description', 'price', 'range_id', 'process_id')
        );

        $frisbee->ingredients()->detach();
        $frisbee->ingredients()->attach($ingredients);

        return $frisbee->with('process')
            ->with('range')
            ->with("ingredients")
            ->get();
    });
    Route::put("/{id}", function (int $id) {
        Frisbee::where("id", $id)->update(request()->all());

        return Frisbee::with('process')
            ->with('range')
            ->with("ingredients")
            ->get();
    });
    Route::delete("/{id}", function (int $id) {
        Frisbee::destroy($id);

        return Frisbee::with('process')
            ->with('range')
            ->with("ingredients")
            ->get();
    });
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
    Route::patch("/{id}", function (int $id) {
        $ingredient = Ingredient::where("id", $id)->firstOrFail();
        return $ingredient->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $ingredient = Ingredient::where("id", $id)->firstOrFail();
        return $ingredient->delete();
    });
});

Route::group(["prefix" => "/process"], function() {
    Route::get("/", function () {
        return Process::with('steps')->get();
    });
    Route::post("/", function (Request $request) {
        $steps = [];

        foreach($request->get("steps") as $step) {
            $steps[] = Ingredient::firstOrCreate(
                ["name" => $step["name"]],
                $step
            )->id;
        }

        $process = Process::firstOrCreate(
            ["name" => $request["name"]],
            $request->all()
        );

        $process->steps()->detach();
        $process->steps()->attach($steps);
    });
    Route::patch("/{id}", function (int $id) {
        $process = Process::where("id", $id)->firstOrFail();
        return $process->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $process = Process::where("id", $id)->firstOrFail();
        return $process->delete();
    });
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
    Route::patch("/{id}", function (int $id) {
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
    Route::post("/", function (Request $request) {
        return Range::firstOrCreate(
            ["name" => $request["name"]],
            $request->all()
        );
    });
    Route::patch("/{id}", function (int $id) {
        $range = Range::where("id", $id)->firstOrFail();
        return $range->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $range = Range::where("id", $id)->firstOrFail();
        return $range->delete();
    });
});
