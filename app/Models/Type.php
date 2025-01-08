<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {

    public function drink() {

        return $this->hasMany( Drink::class );
    }
}
