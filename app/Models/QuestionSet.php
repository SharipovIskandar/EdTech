<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{
    protected $fillable = ['user_id', 'subject_id', 'topic_id', 'language', 'title', 'source'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class);
    }
}