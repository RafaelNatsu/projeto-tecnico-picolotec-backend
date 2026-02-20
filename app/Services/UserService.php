<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    public function __construct(protected UserRepository $userRepository) {
    }

    public function find(int $id){
        try {
            $user = $this->userRepository->find($id);
            return $user;
        } catch (Exception $e) {
            throw new Exception("Usuário não encontrado.",$e->getCode()?: 404);
        }
    }

    public function create(array $data){
        try {
            return $this->userRepository->createUser($data);
        } catch (\Exception $e) {
            throw new Exception('Erro ao criar usuário',$e->getCode()?: 400);
        }
    }

    public function update(array $data, int $id){
        try {
            return $this->userRepository->update($data,$id);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage()?:'Erro ao atualizar o usuário', $e->getCode()?: 400);
        }
    }

    public function delete(int $id){
        try {

            if($id == 1){
                throw new Exception("Este usuário não pode ser removido",400);
            }
            return $this->userRepository->delete($id);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage()?:'Erro ao deletar o usuário', $e->getCode()?: 400);
        }
    }
}
