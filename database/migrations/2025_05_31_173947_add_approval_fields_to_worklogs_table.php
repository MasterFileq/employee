<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('worklogs', function (Blueprint $table) {
            $table->string('status')->default('oczekujący')->after('comment'); // Domyślny status
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_comment')->nullable()->after('approved_at');
            $table->text('approval_comment')->nullable()->after('rejection_comment');
        });
    }

    public function down(): void
    {
        Schema::table('worklogs', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_by', 'approved_at', 'rejection_comment', 'approval_comment']);
        });
    }
};