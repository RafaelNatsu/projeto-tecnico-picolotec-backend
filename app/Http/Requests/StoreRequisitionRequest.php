<?php

namespace App\Http\Requests;

use App\Enums\PriorityLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StoreRequisitionRequest",
    type: "object",
    required: ["title", "description", "estimated_value", "urgency", "importance", "user_id"],
    properties: [
        new OA\Property(property: "title", type: "string", maxLength: 255, example: "Compra de Notebook"),
        new OA\Property(property: "description", type: "string", example: "Necessário para o novo desenvolvedor"),
        new OA\Property(property: "estimated_value", type: "number", format: "float", minimum: 0, example: 4500.50),
        new OA\Property(
            property: "urgency",
            type: "string",
            enum: ["low", "medium", "high"],
            example: "high"
        ),
        new OA\Property(
            property: "importance",
            type: "string",
            enum: ["low", "medium", "high"],
            example: "medium"
        ),
        new OA\Property(property: "user_id", type: "integer", example: 1)
    ]
)]
class StoreRequisitionRequest extends FormRequest
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
            'title'           => ['required', 'string', 'min:2', 'max:255'],
            'description'     => ['required', 'string', 'max:255'],
            'estimated_value' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'urgency'         => ['required', Rule::enum(PriorityLevel::class)],
            'importance'      => ['required', Rule::enum(PriorityLevel::class)]
        ];
    }

    public function messages(): array
    {
        return [

            'title.required' => 'O campo title é obrigatório.',
            'title.string' => 'O título deve ser um texto válido.',
            'title.min' => 'O titulo deve ter no mínimo :min caracteres.',
            'title.max' => 'O titulo deve ter no máximo :max caracteres.',

            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'A descrição deve ser um texto válido.',
            'description.max' => 'O descrição deve ter no máximo :max caracteres.',

            'estimated_value.numeric' => 'O valor estimado deve ser um número.',
            'estimated_value.min' => 'O valor estimado não pode ser negativo.',
            'estimated_value.decimal' => 'O valor deve ter no máximo 2 casas decimais.',

            'urgency.enum' => 'Selecione uma opção valida de urgência.',
            'importance.enum' => 'Selecione uma opção valida de importância.',

        ];
    }
}
