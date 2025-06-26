<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['user_id', 'question_set_id', 'status', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionSet()
    {
        return $this->belongsTo(QuestionSet::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
