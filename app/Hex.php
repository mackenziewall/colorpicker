<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hex extends Model
{
    //
    protected $fillable = ['block', 'value'];
    protected $table = 'hex';

    public function block()
    {
        return $this->belongsTo('App/Block');
    }
}
