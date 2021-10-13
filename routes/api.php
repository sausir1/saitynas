<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReadingController;
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

Route::apiResource('users', UserController::class)->only(['index', 'show']);


// Route::apiResource('badges.users', [BadgeUsersController::class]);
Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::apiResource('posts.comments', CommentController::class)->only(['index', 'show']);
Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::apiResource('posts.comments', CommentController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['show', 'index']);
Route::apiResource('authors.books', BookController::class)->only(['show', 'index']);
Route::apiResource('authors.books.comments', CommentController::class)->only(['show', 'index']);

Route::group(['middleware' => ['auth.jwt']], function () {

    Route::patch('auth', [AuthController::class, 'update']);
    Route::apiResource('users', UserController::class)->except(['index', 'show']);
    Route::apiResource('posts', PostController::class)->except(['index', 'show']);
    Route::apiResource('posts.comments', CommentController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('authors', AuthorController::class)->except(['show', 'index']);
    Route::apiResource('authors.books', BookController::class)->except(['show', 'index']);
    Route::apiResource('authors.books.comments', CommentController::class)->except(['show', 'index']);

    Route::apiResource('badges', BadgeController::class);

    Route::prefix('auth')->group(function () {
        Route::get('', [AuthController::class, 'getUser']);
        Route::post('', [AuthController::class, 'updateUser']);
        Route::post('/alive', [AuthController::class, 'keepAlive']); //keep alive auth user
        Route::get('/badges', [BadgeController::class, 'getUserBadges']); //auth user earned badges
        Route::get('/follows', [FollowController::class, 'getMyFollows']); //what auth user is following
        Route::post('/follows', [FollowController::class, 'follow']); // start to follow
        // TODO: Only logged in user see's this!
        Route::apiResource('readings', ReadingController::class);
        Route::apiResource('readings.notes', NoteController::class);
        Route::apiResource('goals', GoalController::class);
    });
});

Route::fallback(function () {
    return response()->json(["message" => "Whoops! You entered something that doesn't match any of our routes!"], 404);
});
