<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="StoreAuthorRequest",
 *     type="object",
 *     title="Store Author Request",
 *     description="Данные для создания автора",
 *     required={"full_name","email"},
 *     @OA\Property(property="full_name", type="string", example="Айболат Кулатай", description="ФИО автора"),
 *     @OA\Property(property="email", type="string", format="email", example="author@example.com", description="Email автора"),
 *     @OA\Property(property="avatar", type="string", format="binary", nullable=true, description="Аватар автора")
 * )
 */

class StoreAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Необходимо ввести имя автора',
            'full_name.string' => 'Имя должно быть строкой',
            'full_name.max' => 'Имя не может превышать 255 символов',

            'email.required' => 'Необходимо указать email',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Введите корректный адрес электронной почты',
            'email.max' => 'Email не может превышать 255 символов',
            'email.unique' => 'Автор с таким email уже существует',

            'avatar.image' => 'Аватар должен быть изображением',
            'avatar.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif, svg',
            'avatar.max' => 'Размер изображения не должен превышать 2 МБ',
        ];
    }
}
