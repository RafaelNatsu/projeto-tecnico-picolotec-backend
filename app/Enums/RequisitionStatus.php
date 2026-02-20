<?php

namespace App\Enums;

enum RequisitionStatus: string
{
    case UNDER_REVIEW = 'under_review';
    case APPROVED     = 'approved';
    case REJECTED     = 'rejected';
    case COMPLETED    = 'completed';
    case ARCHIVED     = 'archived';

    public function label(): string
    {
        return match($this) {
            self::UNDER_REVIEW => 'Em Revisão',
            self::APPROVED     => 'Aprovado',
            self::REJECTED     => 'Reprovado',
            self::COMPLETED    => 'Finalizado',
            self::ARCHIVED     => 'Arquivado',
        };
    }

}
