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
Route::get('users', [UserController::class, 'index']);
Route::get('users/{user:username}', [UserController::class, 'show'])->name('user');

// Route::apiResource('badges.users', [BadgeUsersController::class]);


Route::group(['middleware' => ['auth.jwt']], function () {

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post:slug}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::patch('/{post:slug}', [PostController::class, 'update']);
        Route::delete('/{post:slug}', [PostController::class, 'destroy']);
    });

    /* BASIC auth user's functions*/
    Route::prefix('auth')->group(function () {
        Route::get('', [AuthController::class, 'getUser']);
        Route::post('/alive', [AuthController::class, 'keepAlive']); //keep alive auth user
        Route::get('/badges', [BadgeController::class, 'getUserBadges']); //auth user earned badges
        Route::get('/follows', [FollowController::class, 'getMyFollows']); //what auth user is following
        Route::post('/follows', [FollowController::class, 'follow']); // start to follow
    });


    /*Autoriai, Autorių knygos, autorių knygos komentarai*/
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('authors.books', BookController::class);
    Route::apiResource('authors.books.comments', CommentController::class);
    /*-------------------------------------------------------------*/

    Route::apiResource('badges', BadgeController::class);


    Route::apiResource(
        'categories',
        CategoryController::class
    );

    /*Auth user's READINGS*/
    Route::prefix('auth/readings')->group(function () {
        Route::get('', [ReadingController::class, 'index']);
        Route::post('', [ReadingController::class, 'store']);
        Route::patch('/{reading}', [ReadingController::class, 'update']);
        Route::get('/{reading}', [ReadingController::class, 'show']);
        Route::delete('/{reading}', [ReadingController::class, 'destroy']);
    });

    /* Auth user's READINGS {NOTES} */
    Route::prefix('auth/readings/{reading}/notes')->group(function () {
        Route::get('', [NoteController::class, 'index']);
        Route::post('', [NoteController::class, 'store']);
        Route::patch('/{note}', [NoteController::class, 'update']);
        Route::get('/{note}', [NoteController::class, 'show']);
        Route::delete('/{note}', [NoteController::class, 'destroy']);
    });

    /* Auth user's GOALS*/
    Route::prefix('auth/goals')->group(function () {
        Route::get('/', [GoalController::class, 'index']);
        Route::get('/{goal}', [GoalController::class, 'show']);
        Route::post('/', [GoalController::class, 'store']);
        Route::delete('/{goal}', [GoalController::class, 'destroy']);
        Route::patch('/{goal}', [GoalController::class, 'update']);
    });
});

Route::get('/', [BookController::class, 'index']);




Route::fallback(function () {
    return response()->json(["message" => "Whoops! You entered something that doesn't match any of our routes!"], 404);
});
