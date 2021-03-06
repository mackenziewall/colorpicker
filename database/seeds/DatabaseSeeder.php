<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\hex;
use App\swatch;
use App\block;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        swatch::truncate();
        block::truncate();
        hex::truncate();

        Model::unguard();

        $this->call(HexTableSeeder::class);

        Model::reguard();
    }
}
