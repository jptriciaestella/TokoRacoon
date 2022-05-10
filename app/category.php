<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function book(){
        return $this->belongsToMany(product::class);
    }
}
