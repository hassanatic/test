<?php

use Illuminate\Http\Request;
use App\Http\Controllers\GeoQuery;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('user-location/store', [GeoQuery::class, 'store']);
Route::get('user-location/get-users', [GeoQuery::class, 'usersWithinRadius']);
// Route::post('user-location/store', function(){
//     dd(444);
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
