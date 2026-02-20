<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Users", description: "Gerenciamento de usuários")]
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    #[OA\Get(
        path: "/api/users/{id}",
        summary: "Busca um usuário por ID",
        tags: ["Users"],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Sucesso", content: new OA\JsonContent(
                properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/UserResource"))
                ],
            )),
            new OA\Response(response: 404, description: "Usuário não encontrado", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function index(int $id){
        $user = $this->userService->find($id);
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    #[OA\Post(
        path: "/api/users",
        summary: "Cria um novo usuário",
        tags: ["Users"],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/StoreUserRequest")),
        responses: [
            new OA\Response(response: 201, description: "Criado com sucesso", content: new OA\JsonContent(
                properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/UserResource"))
                ],
            )),
            new OA\Response(response: 422, description: "Erro de validação", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource")),
            new OA\Response(response: 404, description: "Usuário não encontrado", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function store(StoreUserRequest $request){
        $user = $this->userService->create($request->validated());

        return (new UserResource($user))->response()->setStatusCode(201);

    }

    #[OA\Patch(
        path: "/api/users/{id}",
        summary: "Atualiza um usuário",
        tags: ["Users"],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),new OA\RequestBody(required: true, content: new OA\JsonContent(ref: "#/components/schemas/UpdateUserRequest"))],
        responses: [
            new OA\Response(response: 200, description: "Atualizado com sucesso", content: new OA\JsonContent(
                properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/UserResource"))
                ],
            )),
            new OA\Response(response: 404, description: "Usuário não encontrado", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function update(UpdateUserRequest $request, int $id){

        $user = $this->userService->update($request->validated(),$id);

        return (new UserResource($user))->response()->setStatusCode(200);

    }

    #[OA\Delete(
        path: "/api/users/{id}",
        summary: "Remove um usuário",
        tags: ["Users"],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Deletado com sucesso", content:new OA\JsonContent(ref:"#/components/schemas/SuccessResource")),
            new OA\Response(response: 400, description: "Erro ao deletar", content:new OA\JsonContent(ref:"#/components/schemas/ErrorResource"))
        ]
    )]
    public function delete(int $id){
        $user = $this->userService->delete($id);

        return (new SuccessResource([
            'message'=> "Usuário deletado com sucesso.",
            'code' => 200
            ]))->response()->setStatusCode(200);

    }
}
