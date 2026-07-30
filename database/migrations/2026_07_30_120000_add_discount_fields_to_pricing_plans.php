<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Each tier can now show a struck-through "was" amount and a discount badge
 * alongside the amount actually charged.
 *
 * `price` keeps its meaning — the final amount — so existing rows stay correct
 * and simply render without a discount until a compare price is filled in.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->decimal('compare_price', 10, 2)->nullable()->after('price');
            $table->string('discount_label')->nullable()->after('compare_price');
        });
    }

    public function down(): void
    {
        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->dropColumn(['compare_price', 'discount_label']);
        });
    }
};
