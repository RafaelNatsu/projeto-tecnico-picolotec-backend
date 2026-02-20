<?php

namespace App\Repositories;

use App\Models\User;
use Exception;

class UserRepository
{

    public function __construct(protected User $model) {
    }

    public function getByEmail(string $email) : User
    {
        $user = $this->model->where('email',$email)->first();
        if(!$user){
            throw new Exception("E-mail não encontrado");
        }
        return $user;
    }

    public function find(int $id) : User
    {
        $user = $this->model->where('id',$id)->first();
        if(!$user){
            throw new Exception("Usuário não encontrado ou deletado");
        }
        return $user;
    }

    public function createUser(array $data) : User
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id) : User
    {
        try {
            $user = $this->find($id);
            $user->update($data);

        } catch (\Exception $e) {
            throw new Exception("Erro ao atualizar");
        }
        return $user;
    }

    public function delete(int $id) : bool
    {
        $deleted = $this->find($id)->delete();
        return $deleted;
    }

    public function exists(int $id) : bool
    {
        return $this->model->where('id',$id)->exists();
    }
}
