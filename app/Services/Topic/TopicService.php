<?php

namespace App\Services\Topic;

use App\Models\Topic;
use App\Traits\Crud;
use App\Services\Topic\Contracts\iTopicService;

class TopicService implements iTopicService
{
    use Crud;
    public $modelClass = Topic::class;
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
