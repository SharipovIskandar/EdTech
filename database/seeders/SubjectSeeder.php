<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['code' => 'ENG', 'name' => 'Ingliz tili'],
            ['code' => 'MATH', 'name' => 'Matematika'],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['code' => $subject['code']], $subject);
        }
    }
}
