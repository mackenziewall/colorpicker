<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\hex;
use App\swatch;
use App\block;

class HexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,130) as $index)
        {
            Swatch::create();
        }
    }
}
