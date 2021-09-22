<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);


Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/{book:slug}', [BookController::class, 'show']);
    Route::post('/', [BookController::class, 'create']);
    Route::patch('/{book:slug}', [BookController::class, 'edit']);
    Route::delete('/{book:slug}', [BookController::class, 'delete']);
});

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{post:slug}', [PostController::class, 'show']);
    Route::post('/', [PostController::class, 'create']);
    Route::patch('/{post:slug}', [PostController::class, 'edit']);
    Route::delete('/{post:slug}', [PostController::class, 'delete']);
});

Route::prefix('badges')->group(function () {
    Route::get('/', [BadgeController::class, 'index']);
    Route::get('/{badge}', [BadgeController::class, 'show']);
    Route::post('/', [BadgeController::class, 'create']);
    Route::patch('/{badge}', [BadgeController::class, 'edit']);
    Route::delete('/{badge}', [BadgeController::class, 'delete']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'create']);
    Route::patch('/{category}', [CategoryController::class, 'edit']);
    Route::delete('/{category}', [CategoryController::class, 'delete']);
});

Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index']);
    Route::get('/{author}', [AuthorController::class, 'show']);
    Route::post('/', [AuthorController::class, 'create']);
    Route::patch('/{author}', [AuthorController::class, 'edit']);
    Route::delete('/{author}', [AuthorController::class, 'delete']);
});


Route::group(['middleware' => ['auth.jwt']], function () {
    Route::get('me', [AuthController::class, 'getUser']);
    Route::post('me/alive', [AuthController::class, 'keepAlive']);
    Route::get('me/badges', [BadgeController::class, 'getUserBadges']);
    Route::prefix('me/goals')->group(function () {
        Route::get('/', [GoalController::class, 'index']);
        Route::get('/{goal}', [GoalController::class, 'show']);
        Route::post('/', [GoalController::class, 'create']);
        Route::delete('/{goal}', [GoalController::class, 'delete']);
        Route::patch('/{goal}', [GoalController::class, 'edit']);
    });
});



Route::fallback(function () {
    return response()->json(["message" => "Whoops! you entered something that doesn't match any of our routes!"], 404);
});
