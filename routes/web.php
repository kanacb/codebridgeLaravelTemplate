<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('reauthentication', [AuthController::class, 'reauthentication']);
Route::any('{any}', function () {
    return redirect(env('FRONTEND_URL',"http://localhost:3000"));
})->where('any', '.*')->named("frontend");