<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['homework_id', 'user_id', 'source', 'score', 'comment'];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
