<?php

namespace Database\Seeders;

use App\Models\setting;
use Illuminate\Database\Seeder;

class settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = setting::create([
            'key' => 'overtime_method',
            'value' => '1'
        ]);
    }
}
