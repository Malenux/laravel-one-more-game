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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('platform_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('external_achievement_id')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('icon_url')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('game_id');
            $table->unique(['game_id', 'platform_id', 'external_achievement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
