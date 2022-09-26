<?php

use App\Models\Frisbee;
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
        return Frisbee::all();
    });
    Route::post("/", function (Request $request) {
        return Frisbee::create($request->all());
    });
    Route::patch("/{frisbee}", function (int $id) {
        $frisbee = Frisbee::where("id", $id)->firstOrFail();
        return $frisbee->update(request()->all());
    });
    Route::delete("/{id}", function (int $id) {
        $frisbee = Frisbee::where("id", $id)->firstOrFail();
        return $frisbee->delete();
    });
});
