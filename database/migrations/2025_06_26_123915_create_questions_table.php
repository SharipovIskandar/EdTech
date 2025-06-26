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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_set_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_type_id')->constrained()->onDelete('cascade');
            $table->text('text');                         // savol matni
            $table->json('options')->nullable();         // variantlar
            $table->json('correct_answers')->nullable(); // javoblar
            $table->json('meta')->nullable();            // hint, explanation va h.k.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
