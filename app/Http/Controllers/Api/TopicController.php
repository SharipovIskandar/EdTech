<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TopicStoreRequest;
use App\Http\Resources\TopicResource;
use App\Services\Topic\Contracts\iTopicService;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function __construct(protected iTopicService $service) {}
    public function index(Request $request)
    {
        return TopicResource::collection($this->service->index($request));
    }
    public function store(TopicStoreRequest $request)
    {
        $data = $this->service->store($request);
        return new TopicResource($data);
    }
    public function show($id)
    {
        return new TopicResource($this->service->show($id));
    }
    public function update(TopicStoreRequest $request, $id)
    {
        $data = $this->service->update($id, $request);
        return new TopicResource($data);
    }
    public function destroy($id)
    {
        return response()->json(['message' => __('message.Successfully')]);
    }
}
