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
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable()->index()->constrained('menus')->nullOnDelete();
            $table->string('name');
            $table->string('module_name')->unique();
            $table->string('icon')->nullable();
            $table->string('route')->nullable();
            $table->integer('order')->default(0)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('list_permissions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    Schema::table('permissions', function (Blueprint $table) {
        $table->uuid('menu_id')->nullable()->index()->constrained('menus')->nullOnDelete()->after('name');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('menu_id');
        });

    }
};
