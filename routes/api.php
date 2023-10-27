<?php

use App\Http\Controllers\Autentication;
use App\Http\Controllers\good;
use App\Http\Controllers\transactions;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/transaction', [transactions::class, 'index']);
Route::get('/goods', [good::class, 'index']);


Route::post('/create_transaction', [transactions::class, 'store']);
Route::post('/delete_transaction', [transactions::class, 'deleted']);
Route::post('/searchTransaction', [transactions::class, 'searchTransaction']);
Route::post('/filter', [transactions::class, 'filter']);


Route::post('/login', [Autentication::class, 'login']);
