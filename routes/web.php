<?php

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


Route::get('/', function() {
    return view('welcome');
});

//Route::middleware();


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function() {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware('auth')->group(function() {
    //Route::post('/projects', 'App\Http\Controllers\ProjectController@store');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store']);
    Route::get('/projects', 'App\Http\Controllers\ProjectController@index');
    Route::get('/projects/create', 'App\Http\Controllers\ProjectController@create');
    Route::get('/projects/{project}', 'App\Http\Controllers\ProjectController@show');
    Route::get('/projects/{project}/edit', 'App\Http\Controllers\ProjectController@edit');
    Route::patch('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update']);
    Route::post('/projects/{project}/tasks', [\App\Http\Controllers\ProjectTaskController::class, 'store']);
    Route::patch('/projects/{project}/tasks/{tasks}', [\App\Http\Controllers\ProjectTaskController::class, 'update']);
    Route::delete('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'destroy']);
    Route::post('/projects/{project}/invitations', [\App\Http\Controllers\ProjectInvitationController::class, 'store']);
});

