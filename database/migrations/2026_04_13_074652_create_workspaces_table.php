<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignUuid('owner_id')->index();
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->string('currency')->default('USD');
            $table->string('timezone')->default('UTC');
            $table->string('website')->nullable();
            $table->text('business_address')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('billing_provider')->nullable();
            $table->string('billing_id')->nullable()->index();
            $table->string('subscription_plan_id')->nullable();
            $table->string('subscription_status')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('invoice_prefix')->default('INV-');
            $table->unsignedInteger('next_invoice_number')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
