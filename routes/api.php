<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get( "/drinks", [ DrinkController::class, "getDrinks" ]);
Route::get( "/drink", [ DrinkController::class, "getDrink" ]);
Route::post( "/newdrink", [ DrinkController::class, "newDrink" ]);
Route::put( "/updatedrink", [ DrinkController::class, "updateDrink" ]);
Route::delete( "/deletedrink/{id}", [ DrinkController::class, "destroyDrink" ]);
