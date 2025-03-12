<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BannerController extends Controller {

    public function getLoginCounter( $name ) {

        $user = User::where( "name", $name )->first();
        $counter = $user->logincounter;

        return $counter;
    }

    public function setLoginCounter( $name ) {

        User::where( "name", $name )->increment( "logincounter" );
    }

    public function resetLoginCounter(  $name ) {

        $user = User::where( "name", $name )->first();
        $user->logincounter = 0;

        $user->update();
    }

    public function getBannedTime( $name ) {

        $user = User::where( "name", $name )->first();
        $bannedTime = $user->bannedtime;

        return $bannedTime;
    }

    public function setBannedTime( $name ) {

        $user = User::where( "name", $name )->first();
        $user->bannedtime = Carbon::now()->addSeconds( 60 );

        $user->update();
    }

    public function resetBannedTime( $name ) {

        $user = User::where( "name", $name )->first();
        $user->bannedtime = null;

        $user->update();
    }
}
