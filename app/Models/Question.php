<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question_set_id', 'question_type_id', 'text', 'options', 'correct_answers', 'meta'];

    protected $casts = [
        'options' => 'array',
        'correct_answers' => 'array',
        'meta' => 'array',
    ];

    public function questionSet()
    {
        return $this->belongsTo(QuestionSet::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }
}
