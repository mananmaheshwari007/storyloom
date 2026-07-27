<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * `sidebar_promo` — the sticky book card beside the article (the second
 * promotional book, previously hard-coded in the template).
 * `title_html` — the headline with its <em> accent word preserved;
 * `title` stays plain text so lists, slugs and meta keep working.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('sidebar_promo')->nullable()->after('promo');
            $table->string('title_html')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['sidebar_promo', 'title_html']);
        });
    }
};
