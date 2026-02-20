<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\RequisitionStatus;
use App\Enums\PriorityLevel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('estimated_value', 15, 2);
            $table->string('status')->default(RequisitionStatus::UNDER_REVIEW->value);
            $table->string('urgency')->default(PriorityLevel::LOW->value);
            $table->string('importance')->default(PriorityLevel::LOW->value);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('reviewer_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
