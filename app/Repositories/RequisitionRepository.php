<?php

namespace App\Repositories;

use App\Models\Requisition;
use Illuminate\Database\Eloquent\Builder;

use App\Repositories\Params\RequisitionParams;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Enums\RequisitionStatus;
class RequisitionRepository
{
    public function __construct (protected Requisition $model) {
    }

    public function find(RequisitionParams $params): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        // TODO: criar filtros para outros atributos e remover os arquivados da listagem

        return $this->applyOrder($query, $params)
            ->paginate($params->perPage(), ['*'], 'page', $params->page());
    }

    public function findById(int $id){
        $requisition = $this->model->findOr($id);
        if(!$requisition){
            throw new Exception("Requisição não encontrada");
        }
        return $requisition;
    }

    // public function findByUser(int $userId, RequisitionParams $params): LengthAwarePaginator
    // {
    //     $query = $this->model->where('user_id', $userId);

    //     return $this->applyOrder($query, $params)
    //         ->paginate($params->perPage(), ['*'], 'page', $params->page());
    // }

    public function create(array $data): Requisition
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Requisition
    {
        try {
            $requisition = $this->findById($id);
            $requisition->update($data);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new Exception("Erro ao atualizar");
        }

        return $requisition;
    }

    public function delete(int $id): bool
    {
        try {
            $requisition = $this->findById($id);
            $requisition->delete();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new Exception("Erro ao deletar");
        }

        return true;
    }

    /**
     * Matriz de Priorização (Urgência x Importância)
     */
    private function applyOrder(Builder $query, RequisitionParams $params): Builder
    {

        if ($params->userId()){
            $query->where('user_id',$params->userId());
        }

        if ($params->startDate() && $params->endDate()) {
            $query->whereBetween('created_at', [$params->startDate(), $params->endDate()]);
        }

        //TODO: adicionar filtros de ordenação; exemplo: prioridade ou por data
        $status = RequisitionStatus::ARCHIVED->value;
        return $query->
        orderByRaw(" CASE status WHEN '$status' THEN 1 ELSE 0 END ASC ")->
        orderByRaw("
            (CASE urgency WHEN 'high' THEN 3 WHEN 'medium' THEN 2 ELSE 1 END) * (CASE importance WHEN 'high' THEN 3 WHEN 'medium' THEN 2 ELSE 1 END) DESC
        ")->orderBy('created_at', 'asc');
    }
}
