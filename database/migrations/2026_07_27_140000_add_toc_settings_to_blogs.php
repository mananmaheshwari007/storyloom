<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'show_toc')) {
                $table->boolean('show_toc')->default(true);
            }
            if (!Schema::hasColumn('blogs', 'toc_label')) {
                $table->string('toc_label')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $cols = array_filter(['show_toc', 'toc_label'], fn($col) => Schema::hasColumn('blogs', $col));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
