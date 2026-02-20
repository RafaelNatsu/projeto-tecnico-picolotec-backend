<?php

namespace App\Http\Requests;

use App\Enums\PriorityLevel;
use App\Enums\RequisitionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UpdateRequisitionRequest",
    type: "object",
    description: "Esquema para atualização parcial de uma requisição",
    properties: [
        new OA\Property(property: "title", type: "string", maxLength: 255, example: "Notebook de Alto Desempenho"),
        new OA\Property(property: "description", type: "string", example: "Alteração da descrição original"),
        new OA\Property(property: "estimated_value", type: "number", format: "float", minimum: 0, example: 5200.00),

        new OA\Property(
            property: "status",
            type: "string",
            enum: ["under_review", "approved", "rejected", "completed","archived"],
            example: "under_review"
        ),
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
            example: "high"
        )
    ]
)]
class UpdateRequisitionRequest extends FormRequest
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
            'title'           => ['sometimes', 'string', 'min:2', 'max:255'],
            'description'     => ['sometimes', 'string', 'max:255'],
            'estimated_value' => ['sometimes', 'numeric', 'min:0', 'decimal:0,2'],
            'status'          => ['sometimes', Rule::enum(RequisitionStatus::class)],
            'urgency'         => ['sometimes', Rule::enum(PriorityLevel::class)],
            'importance'      => ['sometimes', Rule::enum(PriorityLevel::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título deve ser um texto válido.',
            'title.min' => 'O título deve ter no mínimo :min caracteres.',
            'title.max' => 'O título deve ter no máximo :max caracteres.',

            'description.string' => 'A descrição deve ser um texto válido.',
            'description.max' => 'A descrição deve ter no máximo :max caracteres.',

            'estimated_value.numeric' => 'O valor estimado deve ser um número.',
            'estimated_value.min' => 'O valor estimado não pode ser negativo.',
            'estimated_value.decimal' => 'O valor deve ter no máximo 2 casas decimais.',

            'status.enum' => 'Selecione um status válido.',
            'urgency.enum' => 'Selecione uma opção válida de urgência.',
            'importance.enum' => 'Selecione uma opção válida de importância.',
        ];
    }
}
