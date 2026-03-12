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
        Schema::create('challenges', function(Blueprint $table){
            $table->id();
            $table->string('word');
            $table->string('category');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
            $table->timestamps();
        });

        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('challenge_id')->nullable()->constrained()->nullOnDelete();
            $table->string('player_name');
            $table->string('category')->nullable();
            $table->string('answer')->nullable();
            $table->integer('mistakes')->default(0);
            $table->integer('score')->default(0);
            $table->enum('status', ['waiting', 'active', 'finished'])->default('waiting');
            $table->boolean('is_inactive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_sessions');
        Schema::dropIfExists('challenges');
    }
};
