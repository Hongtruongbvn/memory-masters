<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
                        $table->boolean('is_admin')->default(false);
            $table->boolean('is_vip')->default(false);
            $table->timestamp('vip_expires_at')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
                        $table->string('verification_token')->nullable();
        });
    }

    public function down(): void {
         Schema::dropIfExists('users');
    }
    
};
