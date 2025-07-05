<?php

namespace App\Models;

use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Scopes;
    protected $fillable = ['subject_id', 'name', 'grade'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questionSets()
    {
        return $this->hasMany(QuestionSet::class);
    }
}
