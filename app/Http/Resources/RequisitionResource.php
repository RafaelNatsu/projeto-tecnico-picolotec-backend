<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RequisitionResource",
    title: "Requisition Resource",
    description: "Estrutura detalhada de retorno de uma requisição",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "title", type: "string", example: "Compra de suprimentos"),
        new OA\Property(property: "description", type: "string", example: "Pedido de novos teclados mecânicos"),
        new OA\Property(property: "estimation_value", type: "number", format: "float", example: 1500.50),
        new OA\Property(property: "status", type: "string", example: "pending"),
        new OA\Property(
            property: "priority",
            type: "object",
            properties: [
                new OA\Property(property: "urgency", type: "integer", example: 5),
                new OA\Property(property: "importance", type: "integer", example: 3),
                new OA\Property(property: "score", type: "integer", example: 15)
            ]
        ),
        new OA\Property(
            property: "permissions",
            type: "object",
            properties: [
                new OA\Property(property: "can_edit", type: "boolean", example: true)
            ]
        ),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time")
    ]
)]
class RequisitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this['id'],
            "title" => $this['title'],
            "description" => $this['description'],
            "estimated_value" => $this['estimated_value'],
            "status"=> $this['status'],
            "priority" => [
                "urgency" => $this['urgency'],
                "importance" => $this['importance'],
                "score" => $this['priority_score']
            ],
            'permissions' => [
                'can_edit' => $request->user()->can('update',$this->resource) ?? false
            ],
            "created_at" => $this['created_at'],
            "updated_at" => $this['updated_at']
        ];
    }
}
