<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    public function up()
    {
        // Fix các session có started_at null hoặc ở tương lai
        \App\Models\StudySession::whereNull('started_at')
            ->orWhere('started_at', '>', now())
            ->update(['started_at' => now()->subMinutes(10)]); // Set về 10 phút trước

        // Fix các session có total_seconds âm
        \App\Models\StudySession::where('total_seconds', '<', 0)
            ->update(['total_seconds' => 300]); // Set mặc định 5 phút
    }

    public function down()
    {
        // Không cần rollback
    }
};