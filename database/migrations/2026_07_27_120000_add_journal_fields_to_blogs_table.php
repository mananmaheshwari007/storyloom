<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Journal writer fields.
 *
 * `blocks` holds the structured post (the editable source of truth).
 * `content` keeps the rendered HTML so the front end can print it
 * directly and older code that reads `content` keeps working.
 * `promo` holds the per-article promotional book card.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('category')->nullable()->after('slug');
            $table->string('dek')->nullable()->after('short_description');
            $table->unsignedSmallInteger('read_time')->nullable()->after('dek');
            $table->json('blocks')->nullable()->after('content');
            $table->json('promo')->nullable()->after('blocks');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['category', 'dek', 'read_time', 'blocks', 'promo']);
        });
    }
};
