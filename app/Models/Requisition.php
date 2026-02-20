<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

use App\Enums\RequisitionStatus;
use App\Enums\PriorityLevel;

class Requisition extends Model
{
    protected $fillable = [
        'title',
        'description',
        'estimated_value',
        'status',
        'urgency',
        'importance',
        'user_id',
        'reviewer_id'
    ];

    protected function casts(): array
    {
        return [
            'status' => RequisitionStatus::class,
            'urgency' => PriorityLevel::class,
            'importance' => PriorityLevel::class,
            'estimated_value' => 'decimal:2',
        ];
    }

    protected $appends = ['priority_score'];
    public function getPriorityScoreAttribute(): int
    {
        return $this->urgency->weight() * $this->importance->weight();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
