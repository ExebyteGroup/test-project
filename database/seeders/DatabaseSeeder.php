<?php

namespace Database\Seeders;

use App\Models\ResultParameter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            QuestionSeeder::class,
            AnswerSeeder::class
        ]);
    }
}
