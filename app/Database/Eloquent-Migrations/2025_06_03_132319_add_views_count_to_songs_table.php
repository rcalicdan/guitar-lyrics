<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for modifying the 'songs' table.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Apply changes to the songs table.
     */
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->integer('views_count')->default(0)->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     * Revert changes applied to the songs table in the up() method.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });
    }
};
