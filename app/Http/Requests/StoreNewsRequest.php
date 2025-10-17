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

    public function messages(): array
    {
        return [
            'title.required' => 'Необходимо указать заголовок новости',
            'title.string' => 'Заголовок должен быть строкой',
            'title.max' => 'Заголовок не может превышать 255 символов',

            'announcement.required' => 'Необходимо указать анонс новости',
            'announcement.string' => 'Анонс должен быть строкой',
            'announcement.max' => 'Анонс не может превышать 255 символов',

            'text.required' => 'Необходимо указать текст новости',
            'text.string' => 'Текст должен быть строкой',

            'publish_date.required' => 'Необходимо указать дату публикации',
            'publish_date.date' => 'Дата публикации должна быть корректной датой',

            'author_id.required' => 'Необходимо указать автора',
            'author_id.integer' => 'ID автора должен быть числом',
            'author_id.exists' => 'Указанный автор не найден',

            'rubrics.array' => 'Рубрики должны быть переданы в виде массива',
            'rubrics.distinct' => 'Рубрики не должны повторяться',
            'rubrics.*.exists' => 'Одна или несколько указанных рубрик не существуют',
        ];
    }
}
