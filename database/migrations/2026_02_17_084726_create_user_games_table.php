<?php

use App\Enums\GameStatus;
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
        Schema::create('user_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('platform_id')->constrained()->cascadeOnDelete();

            $table->enum('status', GameStatus::values())->default(GameStatus::PENDING->value);
            $table->unsignedInteger('played_minutes')->default(0);
            $table->text('personal_notes')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'game_id', 'platform_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_games');
    }
};
