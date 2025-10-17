<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreRubricRequest",
 *     type="object",
 *     title="Store Rubric Request",
 *     description="Данные для создания рубрики",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Спорт", description="Название рубрики"),
 *     @OA\Property(property="parent_id", type="integer", example=2, nullable=true, description="ID родительской рубрики (если есть)")
 * )
 */
class StoreRubricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
