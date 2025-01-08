<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Requests\TypeRequest;

class TypeController extends Controller {

    public function getTypes() {

        $types = Type::all();

        return $this->sendResponse( PackageResource::collection( $types ), "Típusok betöltve");
    }

    public function getType( $typeName ) {

        $type = Package::where( "type", $typeName )->first();

        return $type;
    }

    public function newType( TypeRequest $request ) {

        $request->validated();

        $isType = $this->getType( $request );
        if( is_null( $isType )) {

            $type = new Type();
            $type->type = $request[ "type" ];
            $type->save();

            return $this->sendResponse( new TypeResource( $type ), "Típus kiírva");

        }else {

            return $this->sendError( "Adathiba", [ "A típus létezik" ], 406 );
        }



    }

    public function modifyType( TypeRequest $request, $id ) {

        $request->validated();

        $type = Type::find( $id );
        if( !is_null( $type )) {

            $type->type = $request[ "type" ];

            $type->update();

            return $this->sendResponse( new TypeResource( $type ), "Típus módosítva");

        }else {

            return $this->sendError( "Adathiba", [ "A Nincs Ilyen típus" ], 406 );
        }

    }

    public function destroyType( Request $request ) {

        $type = Type::where( "type", $request[ "type" ]);

        if( !is_null( $type )) {

            $type->delete();

            return $this->sendResponse( new TypeResource( $type ), "Típus törölve" );

        }else {

            return $this->sendError( "Adathiba", [ "Típus nem létezik" ], 405 );
        }


        return response()->json([ "Sikeres törlés", "Típus" => $type ]);
    }

    public function getTypeId( $typeName ) {

        $type = Type::where( "type", $typeName )->first();

        $id = $type->id;

        return $id;
    }
}
