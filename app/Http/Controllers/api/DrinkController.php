<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Http\Resources\Drink as DrinkResource;
use App\Http\Requests\DrinkAddRequest;
use Illuminate\Support\Facades\Gate;

class DrinkController extends ResponseController {

    public function getDrinks() {

        $drinks = Drink::with( "type", "package" )->get();

        return $this->sendResponse( DrinkResource::collection( $drinks ), "Betöltve" );
    }

    public function getDrink( Request $request ) {

        $drink = Drink::where( "drink", $request[ "drink" ])->first();

        return $this->sendResponse( new DrinkResource( $drink ), "Betöltve" );
    }

    public function newDrink( DrinkAddRequest $request ) {

        $user = auth( "sanctum" )->user();
        Gate::before( function( $user ) {
            if( $user->admin == 2 ) {
                return true;
            }
        });
        if( !Gate::allows( "admin" )) {

            return $this->sendError( "Azonosítási hiba", "Nincs jogosultság", 401 );
        }

        $request->validated();
        $drink = new Drink();
        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->type_id = ( new TypeController )->getTypeId( $request[ "type" ]);
        $drink->package_id = ( new PackageController )->getPackageId( $request[ "package" ]);

        $drink->save();

        return $drink;
    }

    public function updateDrink( Request $request ) {

        $drink = $this->getDrink( $request );
        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->type_id = $request[ "type_id" ];
        $drink->package_id = $request[ "package_id" ];

        $drink->save();

        return $drink;
    }

    public function destroyDrink( $id ) {

        $drink = Drink::find( $id );

        $drink->delete();

        return $drink;
    }

    public function isAdmin() {

        if( !Gate::allows( "admin" )) {

            return "admin";
        }

        return "nem admin";
    }
}
