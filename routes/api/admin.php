<?php


use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum', CheckRole::class.':admin'])->prefix('admin')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/roles', [UserController::class, 'assignRoles']);
});