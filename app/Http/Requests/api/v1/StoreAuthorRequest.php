<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
