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
        Schema::create('news_updates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('photo')->nullable();
            $table->foreignId('match_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_updates');
    }
};
