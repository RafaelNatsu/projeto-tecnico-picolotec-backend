<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "RequisitionStatusResource",
    description: "Representação de um status de requisição",
    properties: [
        new OA\Property(property: "value", type: "string", example: "under_review", description: "Identificador do status"),
        new OA\Property(property: "label", type: "string", example: "Em Análise", description: "Nome legível do status")
    ]
)]
class RequisitionStatusResource extends JsonResource
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
            "label" => $this->label()
        ];
    }
}
