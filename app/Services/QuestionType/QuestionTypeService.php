<?php

namespace App\Services\QuestionType;

use App\Models\QuestionType;
use App\Traits\Crud;
use App\Services\QuestionType\Contracts\iQuestionTypeService;

class QuestionTypeService implements iQuestionTypeService
{
    use Crud;

    public $modelClass = QuestionType::class;

    public function index($request)
    {
        return $this->modelClass::query()->customPaginate(request: $request);
    }

    public function store($request)
    {
        return $this->cStore($request);
    }

    public function show($id)
    {
        return $this->modelClass::findOrFail($id);
    }

    public function update($id, $request)
    {
        return $this->cUpdate($request, $id);
    }

    public function destroy($id)
    {
        return $this->cDelete($id);
    }
}
