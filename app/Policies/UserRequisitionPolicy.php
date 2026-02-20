<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Requisition;
use Illuminate\Auth\Access\Response;

class UserRequisitionPolicy
{

    public function view(User $user, Requisition $requisition){

        if ($user->hasAnyRole(["gerente","admin"])){
            return true;
        }

        if ($user->id != $requisition->user_id){
            return Response::deny("Apenas o proprietário original pode realizar alterações nesta requisição.",403);
        }

        return true;
    }

    public function update(User $user, Requisition $requisition){
        if ($user->hasAnyRole(["gerente","admin"])){
            return true;
        }

        if ($user->id != $requisition->user_id){
            return Response::deny("Apenas o proprietário original pode realizar alterações nesta requisição.",403);
        }

        if ($requisition->created_at->diffInHours(now()) > 24){
            return Response::deny("Requisição não pode ser alterada após 24 horas",403);
        }

        return true;
    }

    public function delete(User $user, Requisition $requisition){
        if ($user->hasAnyRole(["gerente","admin"])){
            return true;
        }

        return false;
    }
}
