<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required|max:255',
            'announcement' => 'string|required|max:255',
            'text' => 'string|required',
            'publish_date' => 'date|required',
            'author_id' => 'integer|required|exists:authors,id',
            'rubrics' => 'array|nullable|distinct',
            'rubrics.*' => 'exists:rubrics,id',
        ];
    }
}
