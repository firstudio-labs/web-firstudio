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
        Schema::create('ai_token_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('usage_date');
            $table->integer('tokens_used')->default(0);
            $table->integer('daily_limit')->default(6);
            $table->json('usage_details')->nullable(); // Track individual usage for debugging
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Ensure one record per user per day
            $table->unique(['user_id', 'usage_date']);
            
            // Index for performance
            $table->index(['user_id', 'usage_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_token_usage');
    }
};
