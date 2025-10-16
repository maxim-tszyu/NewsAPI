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
        Schema::create('news_rubric', function (Blueprint $table) {
            $table->foreignId('rubric_id')->constrained()->cascadeOnDelete();
            $table->foreignId('news_id')->constrained()->cascadeOnDelete();
            $table->primary(['rubric_id', 'news_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_rubric');
    }
};
