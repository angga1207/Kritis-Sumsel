<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // like, bookmark
            $table->timestamps();

            $table->unique(['user_id', 'article_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
