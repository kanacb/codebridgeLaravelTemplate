module.exports = `

use App\Http\Controllers\~cb-service-name~Controller;

Route::get('~cb-service-name~s', [~cb-service-name~Controller::class, 'index']);
Route::get('~cb-service-name~s/{id}', [~cb-service-name~Controller::class, 'show']);
Route::post('~cb-service-name~s', [~cb-service-name~Controller::class, 'store']);
Route::put('~cb-service-name~s/{id}', [~cb-service-name~Controller::class, 'update']);
Route::delete('~cb-service-name~s/{id}', [~cb-service-name~Controller::class, 'delete']);
`;