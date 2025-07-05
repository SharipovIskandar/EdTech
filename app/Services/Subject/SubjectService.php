<?php

namespace App\Services\Subject;

use App\Models\Subject;
use App\Services\Subject\Contracts\iSubjectService;
use App\Traits\Crud;

class SubjectService implements iSubjectService
{
    use Crud;
    public $modelClass = Subject::class;

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
