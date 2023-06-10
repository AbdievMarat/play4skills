<?php

use App\Enums\AssignedTaskStatus;
use App\Models\Task;
use App\Models\User;
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
        Schema::create('assigned_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('command')->nullable();
            $table->text('comment')->nullable();
            $table->string('attached_file')->nullable();
            $table->integer('bonus')->default(0);
            $table->string('comment_moderator')->nullable();
            $table->unsignedBigInteger('user_id_moderator')->nullable();
            $table->foreign('user_id_moderator')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', [array_column(AssignedTaskStatus::cases(), 'value')])->default(AssignedTaskStatus::Performed->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_tasks');
    }
};
