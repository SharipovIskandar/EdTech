<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TopicStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string'],
            'grade' => ['required', 'string'],
        ];
    }
}
