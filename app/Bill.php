<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function details()
    {
        return $this->hasMany('App/Detail');
    }
}
