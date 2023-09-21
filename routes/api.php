<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;


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

Route::middleware(['auth:sanctum'])->get('/users', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/events', EventController::class);
});

Route::prefix('events/{event}')->group(function () {
    Route::resource('tickets', TicketController::class)->except(['create', 'edit']);

    Route::patch('{ticket}/check-in', [TicketController::class, 'checkIn']);
});


Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class)->except(['create', 'edit']);
});


