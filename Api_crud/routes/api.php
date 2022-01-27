<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Taskapi;
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
Route::get('/',[Taskapi::class,'index']);
Route::post('/tasks',[Taskapi::class,'store']);
Route::get('/tasks/{id}',[Taskapi::class,'show']);
Route::delete('/tasks/{id}',[Taskapi::class,'destroy']);
Route::put('/tasks',[Taskapi::class,'update']);