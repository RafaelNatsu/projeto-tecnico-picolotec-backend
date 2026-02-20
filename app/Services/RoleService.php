<?php

namespace App\Services;

use App\Repositories\UserRepository;
// use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(protected UserRepository $repository) {
    }
    public function assignRole(array $request){
        $user = $this->getUser($request['user_id']);
        $user->assignRole($this->getRoleByName($request['role_name']));
        return $user->can($this->getRoleByName($request['role_name']));
    }

    public function removeRole(array $request){
        $user = $this->getUser($request['user_id']);

        $user->removeRole($this->getRoleByName($request['role_name']));

        return $user->cant($this->getRoleByName($request['role_name']));
    }

    // public function getRoleUser(User $user){
    //     return $user->getRoleNames();
    // }

    private function getUser(int $id){
        return $this->repository->find($id);
    }

    private function getRoleByName(string $role){
        return Role::findByName($role);
    }
}
