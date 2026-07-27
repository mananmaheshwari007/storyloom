<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Controls for the article's "jump around" contents list. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('show_toc')->default(true)->after('sidebar_promo');
            $table->string('toc_label')->nullable()->after('show_toc');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['show_toc', 'toc_label']);
        });
    }
};
