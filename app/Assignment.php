<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
