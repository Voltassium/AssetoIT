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
        Schema::table('borrowings', function (Blueprint $table) {
            $table->text('reason')->after('device_id');
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending')->after('reason');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->decimal('late_fee', 10, 2)->default(0)->after('actual_return_date');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn(['reason', 'status', 'rejection_reason', 'late_fee', 'approved_at', 'approved_by']);
        });
    }
};
