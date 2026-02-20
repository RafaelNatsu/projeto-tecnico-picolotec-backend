<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\MeResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Models\User;

use App\Services\LoginService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{
    public function __construct(
        protected LoginService $service
    ){}

    public function login(LoginRequest $request)
    {
        $data = $this->service->login($request->validated());
        return (new LoginResource($data))
        ->response()->setStatusCode(response::HTTP_ACCEPTED);
    }

    public function logout(Request $request)
    {

        $resp = $this->service->logout($request);
        return (new SuccessResource([
            "message"=> "Sucesso.",
            "code"=> Response::HTTP_ACCEPTED
        ]))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function me(Request $request)
    {
        $data = $this->service->me($request);
        return (new MeResource($data))->
        response()->setStatusCode(response::HTTP_ACCEPTED);
    }

}
