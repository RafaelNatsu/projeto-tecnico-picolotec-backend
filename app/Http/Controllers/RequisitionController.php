<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequisitionRequest;
use App\Http\Requests\UpdateRequisitionRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\RequisitionResource;
use App\Services\RequisitionService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Requisitions", description: "Operações relacionadas a Requisições")]
class RequisitionController extends Controller
{

    public function __construct(
        protected RequisitionService $requisitionService
    ) {}

    #[OA\Get(
        path: "/api/requisitions/",
        summary: "Busca todas requisições",
        tags: ["Requisitions"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", required:false, schema: new OA\Schema(type: "integer", default: 1)),
            new OA\Parameter(name: "per_page", in: "query", required:false, schema: new OA\Schema(type: "integer", default: 15)),
            // new OA\Parameter(name: "status", in: "query", required:false, schema: new OA\Schema(type: "string")),
            // new OA\Parameter(name: "urgency", in: "query", required:false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "start_date", in: "query", required:false, schema: new OA\Schema(type: "string", format: "date")),
            new OA\Parameter(name: "end_date", in: "query", required:false, schema: new OA\Schema(type: "string", format: "date"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Sucesso",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/RequisitionResource")),
                        new OA\Property(property: "links", type: "object"),
                        new OA\Property(property: "meta", type: "object")
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Não encontrado", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function listAll(Request $request){
        // TODO: passar para validar por um form request
        $filters = $request->query();
        $requisition = $this->requisitionService->listAll($filters);
        return RequisitionResource::collection($requisition);

    }

    #[OA\Get(
        path: "/api/requisitions/{id}",
        summary: "Busca uma requisição pelo ID",
        tags: ["Requisitions"],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Sucesso", content: new OA\JsonContent(
                properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/RequisitionResource")),
                ])
            ),
            new OA\Response(response: 404, description: "Não encontrado", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function index(int $id){
        $user = $this->requisitionService->find($id);
        return (new RequisitionResource($user))->response()->setStatusCode(200);

    }

    #[OA\Post(
        path: "/api/requisitions",
        summary: "Cria uma nova requisição",
        tags: ["Requisitions"],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/StoreRequisitionRequest")),
        responses: [
            new OA\Response(response: 201, description: "Criado com sucesso", content: new OA\JsonContent(
                properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/RequisitionResource"))
                ],
            )),
            new OA\Response(response: 422, description: "Erro de validação", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function store(StoreRequisitionRequest $request){
        $user = $this->requisitionService->create($request->validated());

        return (new RequisitionResource($user))->response()->setStatusCode(201);

    }

    #[OA\Patch(
        path: "/api/requisitions/{id}",
        summary: "Atualiza uma requisição",
        tags: ["Requisitions"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
            new OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/UpdateRequisitionRequest"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Atualizado com sucesso", content: new OA\JsonContent(
                properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/RequisitionResource"))
                ],
            )),
            new OA\Response(response: 404, description: "Não encontrado", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function update(UpdateRequisitionRequest $request, int $id){
        $requisition = $this->requisitionService->update($request->validated(),$id);

        return (new RequisitionResource($requisition))->response()->setStatusCode(200);
    }

    #[OA\Delete(
        path: "/api/requisitions/{id}",
        summary: "Remove uma requisição",
        tags: ["Requisitions"],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Deletado com sucesso", content:new OA\JsonContent(ref:"#/components/schemas/SuccessResource"))
        ]
    )]
    public function delete(int $id){

        $user = $this->requisitionService->delete($id);

        return (new SuccessResource([
            'message'=> "Requisição deletado com sucesso.",
            'code' => 200
            ]))->response()->setStatusCode(200);
    }
}
