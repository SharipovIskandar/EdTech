<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['code', 'name'];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function questionSets()
    {
        return $this->hasMany(QuestionSet::class);
    }
}
