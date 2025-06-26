<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'ENG' => [
                ['name' => 'Vocabulary', 'grade' => '6'],
                ['name' => 'Grammar', 'grade' => '6'],
                ['name' => 'Reading comprehension', 'grade' => '7']
            ],
            'MATH' => [
                ['name' => 'Kasrlar', 'grade' => '6'],
                ['name' => 'Algebra asoslari', 'grade' => '7'],
                ['name' => 'Geometriya', 'grade' => '8']
            ]
        ];

        foreach ($topics as $subjectCode => $topicList) {
            $subject = Subject::where('code', $subjectCode)->first();
            if ($subject) {
                foreach ($topicList as $topic) {
                    Topic::firstOrCreate([
                        'subject_id' => $subject->id,
                        'name' => $topic['name'],
                        'grade' => $topic['grade']
                    ]);
                }
            }
        }
    }
}
