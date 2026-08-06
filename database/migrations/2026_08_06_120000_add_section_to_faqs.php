<?php

use App\Models\Faq;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FAQs are grouped under headings ("Shipping & Delivery" and so on).
 *
 * The section is free text rather than an enum, so a new grouping can be
 * created from the admin at any time just by typing a name — no migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('section')->nullable()->after('answer');
            // Controls the order the groups themselves appear in.
            $table->integer('section_order')->default(0)->after('section');
        });

        // Existing questions all land in one group rather than vanishing from a
        // grouped page because their section is null.
        Faq::whereNull('section')->update([
            'section' => Faq::DEFAULT_SECTION,
        ]);
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['section', 'section_order']);
        });
    }
};
