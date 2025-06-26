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
        Schema::create('question_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ustoz yoki ai
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('topic_id')->nullable()->constrained();
            $table->string('language', 10); // uz, ru, en, cyrl
            $table->string('title')->nullable();
            $table->string('source')->default('user'); // user, ai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_sets');
    }
};
