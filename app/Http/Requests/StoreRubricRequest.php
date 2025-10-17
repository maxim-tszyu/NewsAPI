<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRubricRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:rubrics,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Необходимо указать название рубрики',
            'title.string' => 'Название рубрики должно быть строкой',
            'title.max' => 'Название рубрики не может превышать 255 символов',

            'parent_id.exists' => 'Указанная родительская рубрика не найдена',
        ];
    }
}
