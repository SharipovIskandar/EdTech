<?php

namespace App\Services\Topic\Contracts;

use Illuminate\Http\Request;

interface iTopicService
{
    public function index(Request $request);
    public function store(Request $reuqest);
    public function show($id);
    public function update($id, Request $request);
    public function destroy($id);
}
