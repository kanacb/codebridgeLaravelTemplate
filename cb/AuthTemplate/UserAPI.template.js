export=`

// protecting routes, only verified user can view user_dashboard
Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);


`