<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubjectRequest;
use App\Http\Requests\Api\SubjectStoreRequest;
use App\Http\Requests\Api\SubjectUpdateRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\Services\Subject\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $service;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return SubjectResource::collection($this->service->index($request));
    }

    public function store(SubjectStoreRequest $request)
    {
        $subject = $this->service->store($request);

        return new SubjectResource($subject);
    }

    public function show($id)
    {
        return new SubjectResource($this->service->show($id));
    }

    public function update(SubjectUpdateRequest $request, $id)
    {
        $subject = $this->service->update($id, $request);
        return new SubjectResource($subject);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return success_response(['message' => __('message.Successfully')]);
    }
}
