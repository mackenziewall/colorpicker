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
        $query = $this->hex()->select('block_id', 'value', 'hex.id')->orderBy('hex.created_at', 'asc')->getResults();
        foreach($query->groupBy('block_id')->toArray() as $key => $value)
        {
            $data['blocks'][] = ['id' => $key, 'value' => $value[0]['value']];
        }
        $array = $query->toArray();
        $mostRecent = end($array);
        $data['status'] = $mostRecent['id'];
        $data['lock'] = $this->lock;
        return $data;
    }
    public function hexes()
    {
        $query = $this->hex()->select('block_id', 'value', 'hex.id')->orderBy('hex.created_at', 'desc')->getResults();
        foreach($query->groupBy('block_id')->toArray() as $key => $value)
        {
            $data['blocks'][] = ['id' => $key, 'value' => $value[0]['value']];
        }
        return $data;
    }
    public function lock()
    {
        $this->lock = 1;
        $block->save();
    }
    public function status()
    {
        $query = $this->hex()->select('block_id', 'value', 'hex.id')->orderBy('hex.created_at', 'desc')->getResults();
        #$data['status'] = $query->toArray()[0]['id'];
        return $query->toArray()[0]['id'];
    }

    public function addBlock() {
        $block = new Block;
        $block->swatch_id = $this->id;
        $block->save();
    }
}
