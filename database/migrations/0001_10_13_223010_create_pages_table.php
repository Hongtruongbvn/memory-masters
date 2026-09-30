<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->string('type')->default('card'); 
            $table->integer('position')->default(0);
            $table->text('front_text')->nullable();
            $table->text('back_text')->nullable();
            $table->text('title')->nullable(); 
            $table->text('content')->nullable(); 
            $table->text('front_latex')->nullable();
            $table->text('back_latex')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_back')->nullable();
            $table->string('source')->default('user'); 
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pages');
    }
};