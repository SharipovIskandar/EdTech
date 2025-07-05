<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TopicUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'subject_id' => ['sometimes', 'exists:subjects,id'],
            'name' => ['sometimes', 'string'],
            'grade' => ['sometimes', 'string'],
        ];
    }
}
