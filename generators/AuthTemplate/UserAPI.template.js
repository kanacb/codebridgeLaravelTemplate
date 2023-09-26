module.exports = `


Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);


`;