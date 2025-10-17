<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     type="object",
 *     title="Store User Request",
 *     description="Данные для регистрации пользователя",
 *     required={"name","email","password","password_confirmation"},
 *     @OA\Property(property="name", type="string", example="John Doe", description="Имя пользователя"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com", description="Email пользователя"),
 *     @OA\Property(property="password", type="string", format="password", example="password123", description="Пароль пользователя"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="password123", description="Подтверждение пароля")
 * )
 */

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
