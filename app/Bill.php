<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
