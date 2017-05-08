<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public function bill()
    {
        return $this.$this->belongsTo('App/Bill');
    }
}
