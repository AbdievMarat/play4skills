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
        Schema::table('assigned_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('archived_assigned_task_id')->nullable();
            $table->foreign('archived_assigned_task_id')->references('id')->on('archived_assigned_tasks')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assigned_tasks', function (Blueprint $table) {
            $table->dropForeign('archived_assigned_task_id');
            $table->dropColumn('archived_assigned_task_id');
        });
    }
};
