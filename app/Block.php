<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hex;

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
        $this->save();
        if( empty($color) ) {
            $faker = Faker::create();
            $color = substr($faker->hexcolor,1,6);
        }
        $hex = new Hex;
        $hex->block_id = $this->id;
        $hex->value = $color;
        $hex->save();
        return ['status' => $hex->id];
    }
    /**
     * A Block had many hex entries.
     * 
     * @return \Illuminate\Database\Eloquent\HasMany
     */
    public function hex()
    {
        return $this->hasMany('App\Hex');
    }

    public function swatch()
    {
        return $this->belongsTo('App\Swatch');
    }

    public function iterate( $color )
    {
        $hex = new Hex;;
        $hex->block_id = $this->id;
        $hex->value = str_replace("#", "", $color);
        $hex->save();
        return ['status' => $hex->id];
    }

}
