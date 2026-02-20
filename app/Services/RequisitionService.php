<?php

namespace App\Services;

use App\Repositories\RequisitionRepository;
use App\Repositories\Params\RequisitionParams;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RequisitionService {
    use AuthorizesRequests;

    public function __construct(
        protected RequisitionRepository $repository
        ) {
    }

    public function listAll(array $filters) {
        try {
            if( $this->getAuthUser()->hasRole('usuario')){
                $filters['user_id'] = $this->getAuthUser()->id;
            }

            $params = new RequisitionParams(
                page:      $filters['page'] ?? 1,
                perPage:   $filters['per_page'] ?? 15,
                userId:    $filters['user_id'] ?? null,
                startDate: $filters['start_date'] ?? null,
                endDate:   $filters['end_date'] ?? null
            );

            return $this->repository->find($params);
        } catch (Exception $e) {
            \Log::error("Erro ao listar requisições: ".$e->getMessage());
            throw new Exception($e->getMessage() ?: "Erro ao obter lista de requisições.", $e->getCode() ?: 500);
        }
    }

    public function find(int $id) {
        try {
            $requisition = $this->repository->findById($id);
            $this->authorize('view',$requisition);

            return $requisition;
        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: "Requisição não encontrada.", $e->getCode() ?: 404);
        }
    }

    public function create(array $data) {
        try {
            $data['user_id'] = $this->getAuthUser()->id;
            return $this->repository->create($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao criar requisição', $e->getCode() ?: 400);
        }
    }

    public function update(array $data, int $id) {
        try {
            $requisition = $this->find($id);

            $this->authorize('update',$requisition);

            if ($this->getAuthUser()->hasAnyRole(['admin','gerente'])){
                $data['reviewer_id'] = $this->getAuthUser()->id;
            } else {
                if(isset($data['status'])) {
                    throw new Exception("Usuario não pode alterar status.");
                }
            }


            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao atualizar a requisição', $e->getCode() ?: 400);
        }
    }

    public function delete(int $id) {
        try {
            $requisition = $this->find($id);

            $this->authorize('delete',$requisition);

            return $this->repository->update($id, [
                'reviewer_id' => $this->getAuthUser()->id,
                'status' => 'archived'
                ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao remover a requisição', $e->getCode() ?: 400);
        }
    }

    private function getAuthUser(){
        return auth()->user();
    }
}
