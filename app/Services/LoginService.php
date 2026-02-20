<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\SecurityService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
class LoginService
{
    public function __construct(protected UserRepository $userRepository) {
    }

    public function login(array $credential){

        $user = $this->userRepository->getByEmail($credential['email']);

        if(!$user || !\Hash::check($credential['password'],$user->password)){
        // if(!$user || SecurityService::decrypt($credential['password'] != $user->password)){
            throw new Exception("Email ou senha incorreta.",Response::HTTP_UNAUTHORIZED);
        }

        $user->tokens()->delete();

        $token = $user->createToken('token')->plainTextToken;

        return [
            "user"=> $user,
            "token"=> $token,
            "role"=> $user->getRoleNames()->first()
        ];
    }

    public function logout($request){
        $token = $request->user()->currentAccessToken();

        if (!$token) {
            return false;
        }

        return $token->delete();
    }

    public function me($request){
        $user = $request->user();
        return [
            "user" => $user,
            "role" => $user->getRoleNames()->first()
        ];
    }

}
