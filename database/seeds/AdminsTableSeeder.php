<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder {

    public function run()
    {
        $admin = new \App\Models\Administrators();
        $admin->name  = 'Administrator';
        $admin->email = 'admin@admin.dev';
        $admin->password = bcrypt('qwerty');
        $admin->save();
    }

}