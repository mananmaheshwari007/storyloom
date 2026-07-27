<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('blogs', 'dek')) {
                $table->string('dek')->nullable();
            }
            if (!Schema::hasColumn('blogs', 'read_time')) {
                $table->unsignedSmallInteger('read_time')->nullable();
            }
            if (!Schema::hasColumn('blogs', 'blocks')) {
                $table->json('blocks')->nullable();
            }
            if (!Schema::hasColumn('blogs', 'promo')) {
                $table->json('promo')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $cols = array_filter(['category', 'dek', 'read_time', 'blocks', 'promo'], fn($col) => Schema::hasColumn('blogs', $col));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
