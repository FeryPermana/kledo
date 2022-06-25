<?php

namespace Database\Seeders;

use App\Models\overtime;
use App\Models\reference;
use Illuminate\Database\Seeder;

class references extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reference = reference::create([
            'code' => 'overtime_method',
            'name' => 'Salary / 173',
            'expression' => '(salary / 173) * overtime_duration_total'
        ]);

        $reference = reference::create([
            'code' => 'overtime_method',
            'name' => 'Fixed',
            'expression' => '10000 * overtime_duration_total'
        ]);
    }
}
