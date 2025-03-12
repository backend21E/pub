<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\api\ResponseController;
use Carbon\Carbon;

class UserController extends ResponseController {

    public function register( RegisterRequest $request ) {

        $request->validated();

        $user = User::create([
            "name" => $request[ "name" ],
            "email" => $request[ "email" ],
            "password" => bcrypt( $request[ "password" ]),
            "admin" => $request[ "admin" ]
        ]);

        return $user;
    }

    public function login( Request $request ) {

        //$request->validated();

        if( Auth::attempt([ "name" => $request[ "name"], "password" => $request[ "password" ] ])) {

            $authUser = Auth::user();
            ( new BannerController )->resetLoginCounter( $authUser->name );
            $bannedTime = ( new BannerController )->getBannedTime( $authUser->name );

            if( $bannedTime < Carbon::now() ) {

                ( new BannerController )->resetBannedTime( $authUser->name );
                //$token = $authUser->createToken( $authUser->name."token" )->plainTextToken;
                $data = [
                    "name" => $authUser->name,
                    //"token" => $token
                ];

                return $this->sendResponse( $data, "Sikeres bejelelntkezés" );

            }else {

                $errormessage = [ "message" => "Következő lehetőség:", "time" => $bannedTime ];

                return $this->sendError( "Belépési korlátozás!", [ $errormessage ], 401 );
            }

        }else {

            $counter = ( new BannerController )->getLoginCounter( $request[ "name" ]);
            if( $counter < 3 ) {

                ( new BannerController )->setLoginCounter( $request[ "name" ]);
                return $this->sendError( "Autencikációs hiba", "Hibás felhasználónév vagy jelszó", 401 );

            }else {

                ( new BannerController )->setBannedTime( $request[ "name" ]);
                $bannedTime = ( new BannerController )->getBannedTime( $request[ "name" ]);

                $errormessage = [ "message" => "Következő lehetőség:", "time" => $bannedTime ];

                return $this->sendError( "Autentikációs hiba", [ $errormessage ], 401 );
            }


        }
    }

    public function logout() {

        $user = auth( "sanctum" )->user();
        $user->currentAccessToken()->delete();

        return $this->sendResponse( $user->name, "Sikeres kijelentkezés" );
    }
}
