<?php

namespace App\Services\Subject\Contracts;

use Illuminate\Http\Request;

interface iSubjectService
{
    public function index(Request $request);
    public function store(Request $reuqest);
    public function show($id);
    public function update($id, Request $request);
    public function destroy($id);
}
