<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            QuestionTypeSeeder::class,
            SubjectSeeder::class,
            TopicSeeder::class,
        ]);
    }
}
