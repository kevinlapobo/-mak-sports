<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('spectator')->after('email');
            $table->string('full_name')->nullable()->after('name');
            $table->string('phone')->nullable()->after('full_name');
            $table->integer('player_id')->nullable()->after('phone');
            $table->integer('coach_id')->nullable()->after('player_id');
            $table->integer('team_id')->nullable()->after('coach_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'full_name', 'phone', 'player_id', 'coach_id', 'team_id']);
        });
    }
};
