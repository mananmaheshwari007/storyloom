<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'publish_date_tag')) {
                if (Schema::hasColumn('blogs', 'read_time')) {
                    $table->string('publish_date_tag')->nullable()->after('read_time');
                } else {
                    $table->string('publish_date_tag')->nullable();
                }
            }
            if (!Schema::hasColumn('blogs', 'show_promo')) {
                if (Schema::hasColumn('blogs', 'promo')) {
                    $table->boolean('show_promo')->default(true)->after('promo');
                } else {
                    $table->boolean('show_promo')->default(true);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'publish_date_tag')) {
                $table->dropColumn('publish_date_tag');
            }
            if (Schema::hasColumn('blogs', 'show_promo')) {
                $table->dropColumn('show_promo');
            }
        });
    }
};
