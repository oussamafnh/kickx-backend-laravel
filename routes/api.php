<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SneakerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;




// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

//users

// Routes for all users
Route::get('user/profile', [UserController::class, 'getUserProfile'])->middleware('auth:api');
Route::put('user/profile', [UserController::class, 'updateUserProfile'])->middleware('auth:api');

// Routes for both users and admin
Route::delete('user/delete', [UserController::class, 'deleteselfUser'])->middleware('auth:api');

// Routes for admin only
Route::group(['middleware' => ['auth:api', 'is_admin']], function () {
    Route::delete('user/delete/{id}', [UserController::class, 'deleteUser'])->middleware('auth:api');
    Route::get('user/status/{username}', [UserController::class, 'getStatusByUsername']);
    Route::get('user/statistics', [UserController::class, 'getUserStatistics']);
    Route::get('users', [UserController::class, 'getAllUsers']);
});





//sneakers 



// Routes for all users
Route::get('sneakers', [SneakerController::class, 'index']);
Route::get('sneakers/{id}', [SneakerController::class, 'show']);
Route::get('sneakers/{id}/links', [SneakerController::class, 'getLinks']);
Route::get('filter', [SneakerController::class, 'filter']);


// Routes for admin only
Route::group(['middleware' => ['auth:api', 'is_admin']], function () {
    Route::post('sneakers', [SneakerController::class, 'store']);
    Route::put('sneakers/{id}', [SneakerController::class, 'update']);
    Route::delete('sneakers/{id}', [SneakerController::class, 'destroy']);
});




//reviews :




// Routes for all users
Route::get('sneakers/{sneakerId}/reviews', [ReviewController::class, 'getReviewsBySneaker']);

// Routes for authenticated users
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('reviews', [ReviewController::class, 'store']);
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
});

// Routes for admin only
Route::group(['middleware' => ['auth:api', 'is_admin']], function () {
    Route::delete('reviews/admin/{id}', [ReviewController::class, 'destroy']);
});






//like




Route::group(['middleware' => 'auth:api'], function () {
    Route::post('sneakers/{sneakerId}/like', [LikeController::class, 'toggleLike']);
});