<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkController;
use App\Http\Controllers\api\TypeController;
use App\Http\Controllers\api\PackageController;
use App\Http\Controllers\api\UserController;

Route::middleware( "auth:sanctum" )->group( function() {

    Route::post( "/logout", [ UserController::class, "logout" ]);

    Route::post( "/newdrink", [ DrinkController::class, "newDrink" ]);
    Route::put( "/updatedrink", [ DrinkController::class, "updateDrink" ]);
    Route::delete( "/deletedrink", [ DrinkController::class, "destroyDrink" ]);

    Route::get( "/admin", [ DrinkController::class, "isAdmin" ]);
});

Route::post( "/register", [ UserController::class, "register" ]);
Route::post( "/login", [ UserController::class, "login" ]);


Route::get( "/drinks", [ DrinkController::class, "getDrinks" ]);
Route::get( "/drink", [ DrinkController::class, "getDrink" ]);


Route::get( "/types", [ TypeController::class, "getTypes" ]);

Route::get( "/packages", [ PackageController::class, "getPackages" ]);
