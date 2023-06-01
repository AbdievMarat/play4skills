<?php

use App\Enums\ChatStatus;
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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('content', 500);
            $table->boolean('is_file')->default(false);
            $table->foreignId('user_id_from')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id_to')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', [array_column(ChatStatus::cases(), 'value')])->default(ChatStatus::Inactive->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
