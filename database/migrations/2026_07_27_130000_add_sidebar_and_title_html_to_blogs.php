<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'sidebar_promo')) {
                $table->json('sidebar_promo')->nullable();
            }
            if (!Schema::hasColumn('blogs', 'title_html')) {
                $table->string('title_html')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $cols = array_filter(['sidebar_promo', 'title_html'], fn($col) => Schema::hasColumn('blogs', $col));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
