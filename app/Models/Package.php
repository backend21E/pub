<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model {

    public function drink() {

        return $this->hasMany( Drink::class );
    }
}
