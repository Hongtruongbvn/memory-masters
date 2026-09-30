<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('session_queue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('study_sessions')->onDelete('cascade');
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->integer('queue_position')->default(0);
            $table->string('status')->default('pending'); 
            $table->timestamp('next_review_at')->nullable();
            $table->float('ease_factor')->default(2.5);
            $table->integer('interval_days')->default(0);
            $table->integer('repetition_count')->default(0);
            $table->tinyInteger('last_quality')->nullable();
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('session_queue_items');
    }
};
