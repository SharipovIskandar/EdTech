<?php

namespace App\Services\QuestionType\Contracts;

use Illuminate\Http\Request;

interface iQuestionTypeService
{
    public function index(Request $request);
    public function store(Request $reuqest);
    public function show($id);
    public function update($id, Request $request);
    public function destroy($id);
}
