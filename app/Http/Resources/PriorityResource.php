<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "PriorityResource",
    description: "Representação de um nível de prioridade",
    properties: [
        new OA\Property(property: "value", type: "string", example: "high", description: "Valor enviado ao banco"),
        new OA\Property(property: "label", type: "string", example: "Alta", description: "Texto de exibição amigável"),
        new OA\Property(property: "weight", type: "integer", example: 3, description: "Peso numérico para cálculos de score")
    ]
)]
class PriorityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "value" => $this->value,
            "label" => $this->label(),
            "weight" => $this->weight()
        ];
    }
}
