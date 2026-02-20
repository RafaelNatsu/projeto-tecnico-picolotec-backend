<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "SuccessResource",
    title: "Success Resource",
    description: "Estrutura padrão de resposta de sucesso da API",
    properties: [
        new OA\Property(property: "success", type: "boolean", example: true),
        new OA\Property(property: "code", type: "integer", example: 200),
        new OA\Property(property: "message", type: "string", example: "Recurso encontrado.")
    ]
)]
class SuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'code' => $this['code'],
            'message' => $this['message']
        ];
    }
}
