<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LogworkController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YourworkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/projects', ProjectController::class);
    Route::resource('/tasks', TaskController::class);
    Route::resource('/comments', CommentController::class);
    Route::resource('/logworks', LogworkController::class);
    
    ROute::get('changestatusproject/{id}/{pid}',[ProjectController::class,'changeStatus']);
    Route::get('logworkremoved/{id}',[LogworkController::class,'is_removed']);
    Route::get('download-logworks/{name}',[LogworkController::class,'download']);
    Route::get('commentremoved/{id}',[CommentController::class,'is_removed']);
    Route::get('download-comments/{name}',[CommentController::class,'download']);

    Route::get('create-task/{id}',[TaskController::class,'createTicket']);
    Route::get('task/{id}',[TaskController::class,'index']);
    Route::get('download-attachemnt/{name}',[TaskController::class,'download']);
});

Route::get('/home', [HomeController::class,'index'])->name('home');
Route::resource('/yourwork', YourworkController::class);

Route::get('projectExcel', [ProjectController::class,'excel']);
Route::get('userBlock/{id}', [UserController::class,'userBlock']);
Route::get('editUser/{id}', [UserController::class,'editUser']);

Route::put('updateUser/{id}', [UserController::class,'updateUser']);
Route::get('changePassword/{id}', [UserController::class,'changePassword']);
Route::put('updatePassword/{id}', [UserController::class,'updatePassword']);

Route::resource('/logs', LogController::class);
Route::get('download/{filename}', [LogController::class,'getDownload']);
// LocalizationController
Route::get('lang/{locale}', [LocalizationController::class,'index']);
// ROUTE for getImage from photos folder
Route::get('/photos/{filename}', function ($filename)
{
    $path = storage_path() . '/photos/' . $filename;
    if(!File::exists($path)) abort(404);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('photo');
