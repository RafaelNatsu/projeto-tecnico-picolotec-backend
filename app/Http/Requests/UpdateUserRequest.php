<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UpdateUserRequest",
    title: "Update User Request",
    description: "Requer ao menos um dos campos (name ou password) para processar a atualização.",
    type: "object",
    properties: [
        new OA\Property(property: "name", type: "string", example: "João Silva"),
        new OA\Property(property: "password", type: "string", format: "password", example: "nova_senha123"),
        new OA\Property(property: "password_confirmation", type: "string", format: "password", example: "nova_senha123")
    ]
)]
class UpdateUserRequest extends FormRequest
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
            'name' => ['required_without_all:password','sometimes','string','max:255'],
            'password' => ['required_without_all:name','sometimes','min:6','max:255','confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required_without_all' => 'Forneça ao menos o nome ou a senha para atualizar.',
            'password.required_without_all' => 'Forneça ao menos o nome ou a senha para atualizar.',
            'name.max' => 'O tamanho do nome excedeu o tamanho limite de :max caracteres.',

            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.confirmed'=> 'As senhas não coincidem. Repita a senha.'
        ];
    }
}
