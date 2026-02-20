<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Enums\PriorityLevel;
use App\Enums\RequisitionStatus;
use App\Http\Resources\PriorityResource;
use App\Http\Resources\RequisitionStatusResource;
use OpenApi\Attributes as OA;

class EnumController extends Controller
{
    public function __construct(
    ){}

    #[OA\Get(
        path: "/api/meta/requisitions/priorities",
        summary: "Lista os níveis de prioridade (Urgência/Importância)",
        tags: ["Metadata"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Sucesso",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/PriorityResource")
                        )
                    ]
                )
            )
        ]
    )]
    public function priorityLevel(Request $request)
    {
        return PriorityResource::collection(PriorityLevel::cases());
    }

    #[OA\Get(
        path: "/api/meta/requisitions/status",
        summary: "Lista os status possíveis de uma requisição",
        tags: ["Metadata"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Sucesso",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/RequisitionStatusResource")
                        )
                    ]
                )
            )
        ]
    )]
    public function requisitionStatus(Request $request)
    {
        return RequisitionStatusResource::collection(RequisitionStatus::cases());
    }

}
