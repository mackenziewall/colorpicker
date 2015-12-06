<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Block;
use App\Hex;

class Swatch extends Model
{
    //
    protected $fillable = ['lock'];
    protected $table = 'swatch';
    protected $blocks = array();
    public $initial_blocks = 3;

    public function __construct($attributes = array())  {

        parent::__construct($attributes); // Eloquent

        $this->save();

        //elements
        $block = array();

        foreach(range(1,$this->initial_blocks) as $index)
        {
            $block[$index] = new Block;
            $block[$index]->swatch_id = $this->id;
            $block[$index]->save();
        }
    }

    public function blocks()
    {
        return $this->hasMany('App\Block');
    }

    public function hex()
    {
        return $this->hasManyThrough('App\Hex', 'App\Block');
    }

    public function values()
    {
        $query = $this->hex()->select('block_id', 'value', 'hex.id')->orderBy('hex.created_at', 'desc')->getResults();
        foreach($query->groupBy('block_id')->toArray() as $key => $value)
        {
            $data['blocks'][$key] = $value[0]['value'];
        }
        $data['status'] = $query->toArray()[0]['id'];

        return $data;
    }
    public function status()
    {
        $query = $this->hex()->select('block_id', 'value', 'hex.id')->orderBy('hex.created_at', 'desc')->getResults();
        $data['status'] = $query->toArray()[0]['id'];
        return $data;
    }

}
