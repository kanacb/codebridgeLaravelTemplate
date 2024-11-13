<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\MailQueController;
use App\Http\Controllers\UserInviteController;
use App\Http\Controllers\S3Controller;

// ~cb-controller-paths~ 


use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SectionController;
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
use App\Http\Controllers\StaffinfoController;
use App\Http\Controllers\DynaLoaderController;
use App\Http\Controllers\DynaFieldController;
use App\Http\Controllers\JobQueController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SuperiorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserGuideStepController;
use App\Http\Controllers\UserGuideController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\DocumentStorageController;
use App\Http\Controllers\DepartmentHODController;
use App\Http\Controllers\DepartmentHOController;
use App\Http\Controllers\LoginHistoryController;

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

Route::post('authentication', [AuthController::class, 'login'])->name('login');
Route::delete('authentication', [AuthController::class, 'logout'])->name('logout');
Route::post('register', [AuthController::class, 'store'])->name('register');
Route::post('forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::resource("users", UserController::class);

Route::post('/cache/{key}', [CacheController::class, 'set']);
Route::get('/cache/{key}', [CacheController::class, 'get']);
Route::delete('/cache/{key}', [CacheController::class, 'delete']);
Route::get('/cache/{key}', [CacheController::class, 'exists']);

Route::post('s3uploader', [S3Controller::class, 'upload']);
Route::get('s3uploader/{fileName}', [S3Controller::class, 'get']);
Route::delete('s3uploader/{fileName}', [S3Controller::class, 'delete']);

Route::middleware('auth:sanctum', 'active_user')->group(function () {
    Route::get('usersfullfilled', [UserController::class, 'index']);
    Route::get("usersSchema", [UserController::class, "getSchema"]);
    Route::resource("mailQues", MailQueController::class);
    Route::get("mailQuesSchema", [MailQueController::class, "getSchema"]);
    Route::resource("userInvites", UserInviteController::class);
    Route::get("userInvitesSchema", [UserInviteController::class, "getSchema"]);

    // ~cb-routes-paths~

    Route::resource("companies", CompanyController::class);
    Route::get("companiesSchema", [CompanyController::class, "getSchema"]);
    Route::resource("branches", BranchController::class);
    Route::get("branchesSchema", [BranchController::class, "getSchema"]);
    Route::resource("departments", DepartmentController::class);
    Route::get("departmentsSchema", [DepartmentController::class, "getSchema"]);
    Route::resource("sections", SectionController::class);
    Route::get("sectionsSchema", [SectionController::class, "getSchema"]);
    Route::resource("roles", RoleController::class);
    Route::get("rolesSchema", [RoleController::class, "getSchema"]);
    Route::resource("positions", PositionController::class);
    Route::get("positionsSchema", [PositionController::class, "getSchema"]);
    Route::resource("profiles", ProfileController::class);
    Route::get("profilesSchema", [ProfileController::class, "getSchema"]);
    Route::resource("templates", TemplateController::class);
    Route::get("templatesSchema", [TemplateController::class, "getSchema"]);
    Route::resource("mails", MailController::class);
    Route::get("mailsSchema", [MailController::class, "getSchema"]);
    Route::resource("tests", TestController::class);
    Route::get("testsSchema", [TestController::class, "getSchema"]);
    Route::resource("permissionServices", PermissionServiceController::class);
    Route::get("permissionServicesSchema", [PermissionServiceController::class, "getSchema"]);
    Route::resource("permissionFields", PermissionFieldController::class);
    Route::get("permissionFieldsSchema", [PermissionFieldController::class, "getSchema"]);
    Route::resource("userAddresses", UserAddressController::class);
    Route::get("userAddressesSchema", [UserAddressController::class, "getSchema"]);
    Route::resource("companyAddresses", CompanyAddressController::class);
    Route::resource("loginHistory", LoginHistoryController::class);
    Route::get("loginHistorySchema", [LoginHistoryController::class, "getSchema"]);
    Route::get("companyAddressesSchema", [CompanyAddressController::class, "getSchema"]);
    Route::resource("companyPhones", CompanyPhoneController::class);
    Route::get("companyPhonesSchema", [CompanyPhoneController::class, "getSchema"]);
    Route::resource("userPhones", UserPhoneController::class);
    Route::get("userPhonesSchema", [UserPhoneController::class, "getSchema"]);
    Route::resource("staffinfo", StaffinfoController::class);
    Route::get("staffinfoSchema", [StaffinfoController::class, "getSchema"]);
    Route::resource("dynaLoader", DynaLoaderController::class);
    Route::get("dynaLoaderSchema", [DynaLoaderController::class, "getSchema"]);
    Route::resource("dynaFields", DynaFieldController::class);
    Route::get("dynaFieldsSchema", [DynaFieldController::class, "getSchema"]);
    Route::resource("jobQues", JobQueController::class);
    Route::get("jobQuesSchema", [JobQueController::class, "getSchema"]);
    Route::resource("employees", EmployeeController::class);
    Route::get("employeesSchema", [EmployeeController::class, "getSchema"]);

    Route::resource("superior", SuperiorController::class);
    Route::get("superiorSchema", [SuperiorController::class, "getSchema"]);
    Route::resource("comments", CommentController::class);
    Route::get("commentsSchema", [CommentController::class, "getSchema"]);
    Route::resource("errorLogs", ErrorLogController::class);
    Route::get("errorLogsSchema", [ErrorLogController::class, "getSchema"]);
    Route::resource("inbox", InboxController::class);
    Route::get("inboxSchema", [InboxController::class, "getSchema"]);
    Route::resource("notifications", NotificationController::class);
    Route::get("notificationsSchema", [NotificationController::class, "getSchema"]);
    Route::resource("userGuideSteps", UserGuideStepController::class);
    Route::get("userGuideStepsSchema", [UserGuideStepController::class, "getSchema"]);
    Route::resource("userGuides", UserGuideController::class);
    Route::get("userGuidesSchema", [UserGuideController::class, "getSchema"]);
    Route::resource("userLogins", UserLoginController::class);
    Route::get("userLoginsSchema", [UserLoginController::class, "getSchema"]);
    Route::resource("documentStorages", DocumentStorageController::class);
    Route::get("documentStoragesSchema", [DocumentStorageController::class, "getSchema"]);
    Route::resource("departmentHOD", DepartmentHODController::class);
    Route::get("departmentHODSchema", [DepartmentHODController::class, "getSchema"]);
    Route::resource("departmentHOS", DepartmentHOController::class);
    Route::get("departmentHOSSchema", [DepartmentHOController::class, "getSchema"]);
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
