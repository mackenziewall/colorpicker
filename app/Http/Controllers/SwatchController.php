<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Swatch;
use App\Block;
use App;
use Faker\Factory as Faker;

class SwatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //make our page
        $swatch = new Swatch;
        $swatch->init();
        $swatch->save();
        //return array_merge($swatch->values(),["id" => alphaID($swatch->id)]);
        return redirect('hex/' . alphaID($swatch->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $swatch = Swatch::find(alphaID($id, true));
        if($swatch)
            return $swatch->values();
    }

    public function cloneSwatch(Request $request)
    {
        $old_swatch = Swatch::find(alphaID($request->input('slug'), true));
        $values = $old_swatch->values();

        $new_swatch = new Swatch();
        $new_swatch->init($values['blocks']);
        $new_swatch->save();

        return ['slug' => alphaID($new_swatch->id)];
        
    }

    /**
     * Add Block
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addBlock(Request $request)
    {
        $swatch = Swatch::find(alphaID($request->input('slug'), true));
        $result = $swatch->addBlock($request->input('value'));
        App::make('Pusher')->trigger('swatch_update_trigger_' . $request->input('slug'), 'update', ['message' => 'update transmitted']);
        return $result;
    }

    /**
     * Add Lock
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lock(Request $request)
    {
        $swatch = Swatch::find(alphaID($request->input('slug'), true));
        if(!$swatch)
            return;
        $swatch->lock();
        return $swatch->values();
    }

    /**
     * Display the status/ latest id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check($id, $status)
    {
        $swatch = Swatch::find(alphaID($id, true));
        if($swatch->status() == $status)
            return ["status" => $swatch->status()];
        return $swatch->values();
    }

    /**
     * SASS Export
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sassExport($id)
    {
        $swatch = Swatch::find(alphaID($id, true));
        $values = $swatch->values();
        $sass   = array();
        foreach($values["blocks"] as $block)
        {
            $blocks[] = $block['value'];
        }
        $blocks = array_unique( $blocks );
        foreach($blocks as $block)
        {
            if(empty($block))
                continue;
            $name = colorNamer($block);
            $sass = uniqueKeyArrayPush($sass, [$name => '$' . $name . ": #" . $block . ';']);
        }
        return ["sass" => implode(" \r\n" ,$sass)];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request )
    {
        $swatch = Swatch::find(alphaID($request->input('slug'), true));
        $result = $swatch->updateBlock($request->input('slug'),$request->input('block'),$request->input('value'));
        App::make('Pusher')->trigger('swatch_update_trigger_' . $request->input('slug'), 'update', ['message' => 'update transmitted']);
        return $result;
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete( Request $request )
    {
        $swatch = Swatch::find(alphaID($request->input('slug'), true));
        $result = $swatch->deleteBlock($request->input('slug'),$request->input('block'));
        App::make('Pusher')->trigger('swatch_update_trigger_' . $request->input('slug'), 'update', ['message' => 'update transmitted']);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
