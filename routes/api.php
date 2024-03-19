<?php
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('meeting-rooms', MeetingRoomController::class);
    Route::apiResource('meetings', MeetingController::class);
});

