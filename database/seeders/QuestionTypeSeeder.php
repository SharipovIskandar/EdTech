<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionType;

class QuestionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['code' => 'SCQ', 'name' => 'Single Choice', 'description' => '1 ta to‘g‘ri javob'],
            ['code' => 'MCQ', 'name' => 'Multiple Choice', 'description' => 'Bir nechta to‘g‘ri javob'],
            ['code' => 'TF', 'name' => 'True / False', 'description' => 'Ha yoki yo‘q'],
            ['code' => 'MATCH', 'name' => 'Matching', 'description' => 'Juftlashtirish'],
            ['code' => 'ORDER', 'name' => 'Ordering', 'description' => 'Tartiblash'],
            ['code' => 'FILL', 'name' => 'Fill in the Blank', 'description' => 'Bo‘sh joyni to‘ldirish'],
            ['code' => 'SAQ', 'name' => 'Short Answer', 'description' => 'Qisqa matnli javob'],
            ['code' => 'ESSAY', 'name' => 'Essay', 'description' => 'Insho yoki izoh'],
            ['code' => 'CODE', 'name' => 'Code Writing', 'description' => 'Kod yozish topshirig‘i'],
            ['code' => 'IMAGE', 'name' => 'Image-based', 'description' => 'Rasm asosidagi savol']
        ];

        foreach ($types as $type) {
            QuestionType::firstOrCreate(['code' => $type['code']], $type);
        }
    }
}
