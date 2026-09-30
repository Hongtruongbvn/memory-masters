<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->string('study_method')->default('SM2');
             $table->timestamp('next_review_at')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['normal', 'vocab', 'formula'])->default('normal');
            $table->string('subject')->nullable();
            $table->boolean('is_private')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->integer('page_limit')->default(100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notes');
    }
};
