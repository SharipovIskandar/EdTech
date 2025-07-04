<?php

namespace App\Models;

use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use Scopes;
    
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
