<?php

use Illuminate\Database\Seeder;
class PackagesTableSeeder extends Seeder {

    public function run()
    {
        \App\Models\Package::create(['title' => 'ORIGINAL']);
        \App\Models\Package::create(['title' => 'ACTIVE']);
        \App\Models\Package::create(['title' => 'FREE TRIAL']);
    }

}