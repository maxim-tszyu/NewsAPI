<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не может превышать :max символов.',

            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.string' => 'Email должен быть строкой.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.max' => 'Email не может превышать :max символов.',
            'email.unique' => 'Такой email уже зарегистрирован.',

            'password.required' => 'Пароль обязателен для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать минимум :min символов.',
            'password.confirmed' => 'Пароль и подтверждение пароля не совпадают.',

            'password_confirmation.required' => 'Подтвердите пароль.',
            'password_confirmation.string' => 'Подтверждение пароля должно быть строкой.',
            'password_confirmation.min' => 'Подтверждение пароля должно содержать минимум :min символов.',
            'password_confirmation.same' => 'Пароль и подтверждение должны совпадать.',
        ];
    }
}
