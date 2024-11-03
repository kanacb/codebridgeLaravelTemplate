<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CacheController;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PermissionServiceController;
use App\Http\Controllers\PermissionFieldController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CompanyAddressController;
use App\Http\Controllers\CompanyPhoneController;
use App\Http\Controllers\UserPhoneController;
use App\Http\Controllers\UserInviteController;
use App\Http\Controllers\StaffinfoController;
use App\Http\Controllers\DynaLoaderController;
use App\Http\Controllers\DynaFieldController;
use App\Http\Controllers\JobQueController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MailQueController;
use App\Http\Controllers\SuperiorController;

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

Route::get('authentication', [AuthController::class, 'login'])->name('login');
Route::post('users', [AuthController::class, 'store'])->name('register');
Route::post('forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::resource('mailQues', MailQueController::class);
Route::resource("userInvites", UserInviteController::class);
Route::get("userInvitesSchema", [UserInviteController::class, "getSchema"]);
Route::get("users", [UserController::class, 'index']);

Route::post('/cache/{key}', [CacheController::class, 'set']);
Route::get('/cache/{key}', [CacheController::class, 'get']);
Route::delete('/cache/{key}', [CacheController::class, 'delete']);
Route::get('/cache/{key}', [CacheController::class, 'exists']);

Route::middleware('auth:sanctum', 'active_user')->group(function () {
    Route::get('usersfullfilled', [UserController::class, 'index']);
    Route::get("usersSchema", [UserController::class, "getSchema"]);
    Route::get("users", [UserController::class, 'index']);
    Route::post('change_password', [AuthController::class, 'change'])->name('change');

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
Route::any('{url?}/{sub_url?}/{params?}', function (Request $request, $url = null, $sub_url = null, $params = null) {
    return response()->json([
        'statusCode' => 404,
        'status' => false,
        'message' => "Route not found",
        'data' => [
            [
                'path' => $request->path(),
                'method' => $request->method(),
                'no_such_url' => $url . '/' . $sub_url,
                'params' => $params,
                'message'   => 'API Not Found.'
            ]
        ],
    ], 404);
});
