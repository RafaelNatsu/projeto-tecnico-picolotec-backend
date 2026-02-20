<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ErrorResource",
    title: "Error Resource",
    description: "Estrutura padrão de resposta de erro da API",
    properties: [
        new OA\Property(property: "success", type: "boolean", example: false),
        new OA\Property(property: "code", type: "integer", example: 404),
        new OA\Property(property: "message", type: "string", example: "Recurso não encontrado.")
    ]
)]
class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => false,
            'code' => $this['code'],
            'message' => $this['message']
        ];
    }
}
