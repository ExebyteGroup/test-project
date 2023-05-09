<?php

namespace Database\Seeders;

use App\Models\ResultParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResultParameter::create([
            'name' => 'Introvert',
            'description' => ''
        ]);

        ResultParameter::create([
            'name' => 'Extrovert',
            'description' => ''
        ]);
    }
}
