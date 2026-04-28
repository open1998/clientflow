<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('workspace_id')->index();
            $table->foreignUuid('task_id')->index();
            $table->foreignUuid('user_id')->index();
            $table->text('description')->nullable();
            $table->datetime('started_at');
            $table->datetime('ended_at')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->boolean('is_billable')->default(true);
            $table->boolean('is_billed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
