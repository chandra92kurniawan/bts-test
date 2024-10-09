<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ItemController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/reg', function () {
//     return view('welcome');
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login','login');
});

Route::middleware(['checkMiddleware'])->group(function () {
    Route::controller(ChecklistController::class)->group(function () {
        Route::get('/checklist', 'list');
        Route::post('/checklist', 'create');
        Route::delete('/checklist/{id}', 'delete');
    });
    Route::controller(ItemController::class)->group(function () {
        Route::get('/checklist/{id}/item', 'list');
        Route::get('/checklist/{id}/item/{item_id}', 'listItem');
        Route::post('/checklist/{id}/item', 'createItem');
        Route::put('/checklist/{id}/item/{item_id}', 'updateStatus');
        Route::put('/checklist/{id}/item/rename/{item_id}', 'renameItem');
        Route::delete('/checklist/{id}/item/{item_id}', 'deleteItem');
    });
});