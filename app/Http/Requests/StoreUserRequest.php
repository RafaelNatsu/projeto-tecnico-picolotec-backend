<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StoreUserRequest",
    type: "object",
    required: ["name", "email", "password"],
    properties: [
        new OA\Property(property: "name", type: "string", example: "João Silva"),
        new OA\Property(property: "email", type: "string", example: "joao@email.com"),
        new OA\Property(property: "password", type: "string", example: "secret123"),
        new OA\Property(property: "password_confirmation", type: "string", example: "secret123")
    ]
)]
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:6','max:255','confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este endereço de e-mail já está sendo utilizado.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.max' => 'O tamanho do e-mail excedeu o tamanho limite de :max caracteres.',

            'name.max' => 'O tamanho do nome excedeu o tamanho limite de :max caracteres.',

            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.confirmed'=> 'As senhas não coincidem. Repita a senha.'
        ];
    }
}
