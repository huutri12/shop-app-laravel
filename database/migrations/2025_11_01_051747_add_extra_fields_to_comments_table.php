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
        Schema::table('comments', function (Blueprint $table) {
            $table->string('avatar_user')->nullable()->after('content');
            $table->string('name_user')->nullable()->after('avatar_user');
            $table->unsignedTinyInteger('level')->default(0)->after('name_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['avatar_user', 'name_user', 'level']);
        });
    }
};
