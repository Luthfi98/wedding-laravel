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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip_address');
            $table->uuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('method', 25);
            $table->string('table', 50);
            $table->text('data')->nullable();
            $table->text('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
