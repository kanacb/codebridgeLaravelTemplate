<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// ~cb-controller-paths~ 

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

Route::post('authentication' , [AuthController::class,'login'])->name('login');
Route::post('users', [AuthController::class, 'store'])->name('register');
Route::post('reauthentication', [AuthController::class,'reauth'])->name('reauth');
Route::post('forgot' , [AuthController::class,'forgot'])->name('forgot');

Route::middleware('auth:sanctum','active_user')->group(function (){
    Route::get('usersfullfilled', [UserController::class, 'index']);
    Route::get("usersSchema", [UserController::class, "getSchema"]);
    Route::post('change_password' , [AuthController::class,'change'])->name('change');
    // ~cb-routes-paths~
});


// exceptions
Route::post('/exceptions', function (Request $request) {
    // Exceptions::create([
    //     'device_id' => $request->device_id,
    //     'error_type' => $request->error_type,
    //     'function_name' => $request->function_name,
    //     'request_uri' => $request->request_uri,
    //     'request_headers' => $request->request_headers,
    //     'request_body' => $request->request_body,
    //     'error_body' => $request->error_body,
    // ]);
    return response()->json(['received' => 'ok', 'statusCode' => '200']);
})->name('exceptions');


// bad routes
Route::any('{url?}/{sub_url?}/{params?}', function(Request $request, $url = null, $sub_url = null, $params = null){
    return response()->json([
        'statusCode' => 404,
        'status' => false,
        'message' => "Route not found",
        'data' => [
            [
                'path' => $request->path(),
                'method' => $request->method(),
                'no_such_url' => $url .'/'.$sub_url,
                'params' => $params,
                'message'   => 'API Not Found.'
            ]
        ],
    ], 404);
});
