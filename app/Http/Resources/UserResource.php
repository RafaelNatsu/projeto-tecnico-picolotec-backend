<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UserResource",
    title: "User Resource",
    description: "Modelo de resposta dos dados do usuário",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "João Silva"),
        new OA\Property(property: "email", type: "string", example: "joao@exemplo.com"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2024-03-20T15:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2024-03-20T15:30:00Z")
    ]
)]
class UserResource extends JsonResource
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
            "name" => $this['name'],
            // "email" => $this['email'],
            // "created_at" => $this['created_at'],
            // "updated_at" => $this['updated_at']
        ];
    }
}
