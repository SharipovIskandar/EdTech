<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QuestionTypeStoreRequest;
use App\Http\Resources\QuestionTypeResource;
use App\Services\QuestionType\Contracts\iQuestionTypeService;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{
    public function __construct(protected iQuestionTypeService $service) {}

    public function index(Request $request)
    {
        return QuestionTypeResource::collection($this->service->index($request));
    }

    public function store(QuestionTypeStoreRequest $request)
    {
        return new QuestionTypeResource($this->service->store($request));
    }

    public function show($id)
    {
        return new QuestionTypeResource($this->service->show($id));
    }

    public function update(QuestionTypeStoreRequest $request, $id)
    {
        return new QuestionTypeResource($this->service->update($id, $request));
    }

    public function destroy($id)
    {
        return response()->json(['message' => __('message.Successfully')]);
    }
}
