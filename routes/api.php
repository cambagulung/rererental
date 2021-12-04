<?php

use App\Extensions\Helpers\Route\Route;
use App\Http\Controllers\Api\Endpoint\EndpointController;
use App\Http\Controllers\Api\V1;

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

Route::name('api.')->group(function ()
{
    Route::namedPrefix('endpoint')->group(function ()
    {
        Route::get('{prefix}', [EndpointController::class, 'index']);
    });

    Route::namedPrefix('v1')->group(function ()
    {
        Route::namedPrefix('user')->group(function ()
        {
            Route::post([V1\User\UserController::class, 'create']);
            Route::middleware('auth:sanctum')->group(function ()
            {
                Route::get([V1\User\UserController::class, 'index']);
                Route::prefix('{user}')->group(function ()
                {
                    Route::get([V1\User\UserController::class, 'show']);
                    Route::patch([V1\User\UserController::class, 'update']);
                    Route::delete([V1\User\UserController::class, 'destroy'])->middleware('can:delete,user');
                });
            });
        });

        Route::namedPrefix('auth')->group(function ()
        {
            Route::post('token', [V1\Auth\Token\TokenController::class, 'store'])->middleware('auth:simple');
            Route::middleware('auth:sanctum')->group(function ()
            {
                Route::namedPrefix('session')->group(function ()
                {
                    Route::get([V1\Auth\Session\SessionController::class, 'verify']);
                    Route::delete([V1\Auth\Session\SessionController::class, 'destroy']);
                });

                Route::namedPrefix('token')->group(function ()
                {
                    Route::get([V1\Auth\Token\TokenController::class, 'index']);
                    Route::delete('{accessToken}', [V1\Auth\Token\TokenController::class, 'destroy'])->middleware('can:delete,accessToken');
                });
            });
        });
    });
});
