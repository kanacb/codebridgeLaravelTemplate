<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;

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

Route::prefix('auth')->group(function () {
    Route::post('login' , [AuthController::class,'login'])->name('login');
    Route::post('auth', [AuthController::class,'authenticate'])->name('auth');
    Route::post('reauth', [AuthController::class,'reauth'])->name('reauth');
    Route::post('login' , [AuthController::class,'login'])->name('login');
    Route::post('login' , [AuthController::class,'login'])->name('login');
    Route::post('login' , [AuthController::class,'login'])->name('login');
    Route::post('login' , [AuthController::class,'login'])->name('login');
});

Route::middleware('auth:sanctum','active_user')->group(function (){
    Route::prefix('~cb-service-name')->group(function () {
        Route::post('/submitQr', [QrController::class,'submitQr'])->name('submitQr');
    });
});



// exceptions
Route::post('/exceptions', function (Request $request) {
    Exceptions::create([
        'device_id' => $request->device_id,
        'error_type' => $request->error_type,
        'function_name' => $request->function_name,
        'request_uri' => $request->request_uri,
        'request_headers' => $request->request_headers,
        'request_body' => $request->request_body,
        'error_body' => $request->error_body,
    ]);
    return response()-json(['received' => 'ok', 'statusCode' => '200']);
})->name('exceptions');


// bad routes
Route::any('{url?}/{sub_url?}', function(Request $request, $url, $sub_url){
    return response()->json([
        'statusCode' => 404,
        'status' => false,
        'message' => "Route not found",
        'data' => [
            [
                'path' => $request->path(),
                'method' => $request->method(),
                'no_such_url' => $url .'/'.$sub_url,
                'message'   => 'API Not Found.'
            ]
        ],
    ], 404);
});
