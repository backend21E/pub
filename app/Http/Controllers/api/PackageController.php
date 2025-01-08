<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Requests\PackageRequest;
use App\Http\Controllers\api\ResponseController;
use App\Http\Resources\Package as PackageResource;

class PackageController extends ResponseController {

    public function getPackages() {

        $packages = Package::all();

        return $this->sendResponse( PackageResource::collection( $packages ), "Kiszerelések betöltve");
    }

    public function getPackage( $packageName ) {

        $package = Package::where( "package", $packageName )->first();

        return $package;
    }

    public function newPackage( PackageRequest $request ) {

        $request->validated();

        $isPackage = $this->getPackage( $request );
        if( is_null( $isPackage )) {

            $package = new Package();
            $package->package = $request[ "package" ];

            $package->save();

            return $this->sendResponse( new PackageResource( $package ), "Kiszerelés kiírva");

        }else {

            return $this->sendError( "Adathiba", [ "A kiszerelés létezik" ], 406 );
        }
    }
// javítani
    public function modifyPackage( PackageRequest $request, $id  ) {

        $request->validated();

        $package = Package::find( $id )->first();
        if( !is_null( $package )) {

            $package->package = $request[ "package" ];

            //$package->update();

            return $this->sendResponse( new PackageResource( $package ), "Kiszerelés módosítva");

        }else {

            return $this->sendError( "Adathiba", [ "A Nincs Ilyen kiszerelés" ], 406 );
        }

    }

    public function destroyPackage( Request $request ) {

        $package = Package::where( "package", $request[ "package" ])->first();

        if( !is_null( $package )) {

            $package->delete();

            return $this->sendResponse( new PackageResource( $package ), "Kiszerelés törölve" );

        }else {

            return $this->sendError( "Adathiba", [ "Kiszerelés nem létezik" ], 405 );
        }



    }

    public function getPackageId( $packageName ) {

        $package = Package::where( "package", $packageName )->first();

        $id = $package->id;

        return $id;
    }
}
