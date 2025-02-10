<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\api\ResponseController;

class UserController extends ResponseController {

    public function register( RegisterRequest $request ) {

        $request->validated();

        $user = User::create([
            "name" => $request[ "name" ],
            "email" => $request[ "email" ],
            "password" => bcrypt( $request[ "password" ])
        ]);

        return $user;
    }

    public function login( Request $request ) {

        //$request->validated();

        if( Auth::attempt([ "name" => $request[ "name"], "password" => $request[ "password" ] ])) {

            $authUser = Auth::user();
            $token = $authUser->createToken( $authUser->name."token" )->plainTextToken;
            $data = [
                "name" => $authUser->name,
                "token" => $token
            ];

            return $this->sendResponse( $data, "Sikeres bejelelntkezés" );
        }
    }

    public function logout() {

    }
}
