<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class Block extends Model
{
    //
    protected $fillable = ['swatch'];
    protected $table = 'block';

    public function __construct($attributes = array())  
    {
        parent::__construct($attributes); // Eloquent
    }
    public function init( $color = '' )  
    {
        if( empty($color) ) {
            $faker = Faker::create();
            $color = substr($faker->hexcolor,1,6);
        }
        $this->value = $color;
        $this->save();
        return ['status' => $this->created_at];
    }

    public function swatch()
    {
        return $this->belongsTo('App\Swatch');
    }

    public function iterate( $color )
    {
        $this->value = str_replace("#", "", $color);
        $this->save();
        return ['status' => strtotime($this->updated_at)];
    }

}
