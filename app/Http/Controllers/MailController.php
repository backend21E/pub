<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\BannerMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {

    public function sendMail( $user, $bannedTime ) {

        $content = [

            "title" => "Felhaszáló tíltása",
            "user" => $user,
            "time" => $bannedTime
        ];
        Mail::to( "laravelfejlesztes@gmail.com" )->send( new BannerMail( $content ));

    }
}
