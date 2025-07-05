<?php

namespace App\Models;

use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use Scopes;
    protected $fillable = ['code', 'name', 'description'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}