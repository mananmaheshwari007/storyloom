<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('type')->default('featured'); // 'featured' or 'shelf'
            $table->string('relation_tag')->nullable();  // e.g. "For a wife"
            $table->string('occasion_tag')->nullable();  // e.g. "Birthday"
            $table->string('spreads_count')->nullable(); // e.g. "15 spreads"
            $table->string('read_time')->nullable();     // e.g. "8 min read"
            $table->text('synopsis')->nullable();
            $table->string('caption')->nullable();       // e.g. "the actual cover — printed, bound, gifted"
            $table->string('cover_image')->nullable();
            $table->string('back_image')->nullable();
            $table->json('pages_json')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_books');
    }
};
