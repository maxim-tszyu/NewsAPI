<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreNewsRequest",
 *     type="object",
 *     title="Store News Request",
 *     description="Данные для создания новости",
 *     required={"title","announcement","text","publish_date","author_id"},
 *     @OA\Property(property="title", type="string", example="Заголовок новости", description="Заголовок новости"),
 *     @OA\Property(property="announcement", type="string", example="Краткое описание", description="Анонс новости"),
 *     @OA\Property(property="text", type="string", example="Полный текст новости", description="Текст новости"),
 *     @OA\Property(property="publish_date", type="string", format="date-time", example="2025-10-17 12:00:00", description="Дата и время публикации"),
 *     @OA\Property(property="author_id", type="integer", example=1, description="ID автора"),
 *     @OA\Property(property="rubrics", type="array", @OA\Items(type="integer"), nullable=true, description="Список ID рубрик")
 * )
 */
class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
