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

    }
    public function init( $colors = null )  {
        $this->save();

        //elements
        $block = array();

        if(is_array($colors))
        {
            foreach($colors as $key => $value)
            {
                $block[$key] = new Block;
                $block[$key]->init($value["value"]);
                $block[$key]->swatch_id = $this->id;
                $block[$key]->save();
            }
        }
        else
        {
            foreach(range(1,$this->initial_blocks) as $index)
            {
                $block[$index] = new Block;
                $block[$index]->init();
                $block[$index]->swatch_id = $this->id;
                $block[$index]->save();
            }
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
            if(!empty($value[0]['value']))
                $data['blocks'][$key] = ['id' => $key, 'value' => $value[0]['value']];
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
        $blocks = array();
        foreach($query->groupBy('block_id')->toArray() as $key => $value)
        {
            $blocks[$key] = ['id' => $key, 'value' => $value[0]['value']];
        }
        $data['blocks'] = array_values($blocks);
        return $data;
    }
    public function lock()
    {
        $this->lock = 1;
        $this->save();
    }
    public function status()
    {
        $query = $this->hex()->select('block_id', 'value', 'hex.id')->orderBy('hex.created_at', 'desc')->getResults();
        #$data['status'] = $query->toArray()[0]['id'];
        return $query->toArray()[0]['id'];
    }

    public function addBlock( $color = null ) {
        if ($this->lock)
            return false;
        $block = new Block;
        $block->swatch_id = $this->id;
        $data = $block->init( $color );
        $block->save();
        return array_merge([ 'id' => $block->id], $data);
    }

    public function updateBlock( $slug, $blockid, $value ) {
        if ($this->lock)
            return false;
        $blocks = Block::find($blockid);
        $blocks = $this->blocks()->where('id', $blockid);

        if( $blocks->count() == 0 )
            return false;

        $block = $blocks->first();

        if( alphaID($block->swatch_id) != $slug )
            return false;

        return $block->iterate($value);
    }

    public function deleteBlock( $slug, $blockid ) {
        $this->updateBlock($slug, $blockid, '');
    }
}
