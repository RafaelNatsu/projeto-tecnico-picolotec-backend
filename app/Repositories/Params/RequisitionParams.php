<?php

namespace App\Repositories\Params;

use Illuminate\Support\Carbon;

class RequisitionParams
{
    private ?int $page;
    private ?int $perPage;
    private ?int $userId;
    private ?Carbon $startDate;
    private ?Carbon $endDate;

    public function __construct(
        ?int $page = 1,
        ?int $perPage = 15,
        ?int $userId = null,
        ?string $startDate = null,
        ?string $endDate = null,
    ) {
        $this->page = $page ?? 1;
        $this->perPage = $perPage ?? 15;
        $this->userId = $userId;
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function page(): int {
        return $this->page;
    }
    public function perPage(): int {
        return $this->perPage;
    }
    public function userId(): ?int {
        return $this->userId;
    }
    public function startDate(): ?Carbon {
        return $this->startDate;
    }
    public function endDate(): ?Carbon {
        return $this->endDate;
    }
}
