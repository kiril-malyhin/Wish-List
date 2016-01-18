<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{

    protected $table = 'friend';

    public function category ()
    {
        return $this->belongsTo('App\Models\Category');
    }


}