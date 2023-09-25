<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;
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

// Public route to view all events
Route::get('/events', [EventController::class, 'index']);

Route::middleware(['auth:sanctum'])->get('/users', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/events', EventController::class)->except('index');
});

Route::prefix('events/{event}')->group(function () {
    Route::apiResource('tickets', TicketController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('events.ticket-types', TicketTypeController::class);
});

Route::middleware(['auth:sanctum'])->patch('{ticket}/check-in', [TicketController::class, 'checkIn']);

Route::put('orders', [OrderController::class, 'store']);


Route::middleware(['auth'])->group(function () {
    Route::apiResource('orders', OrderController::class);

    Route::put('orders/{order}/refund', [OrderController::class, 'refund']);
});

Route::get('/stripe',         [PaymentController::class, 'index']);
Route::post('/stripe/payment', [PaymentController::class, 'payment']);
