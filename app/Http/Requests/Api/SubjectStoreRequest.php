<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubjectStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'unique:subjects,code,' . $this->subject?->id],
        ];
    }
}
