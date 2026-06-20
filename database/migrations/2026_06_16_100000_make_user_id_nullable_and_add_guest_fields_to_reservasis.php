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
        Schema::table('reservasi', function (Blueprint $table) {
            // Make user_id nullable (requires doctrine/dbal when changing existing column)
            if (Schema::hasColumn('reservasi', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->change();
            }

            // Add guest fields for anonymous reservations
            if (!Schema::hasColumn('reservasi', 'guest_name')) {
                $table->string('guest_name')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('reservasi', 'guest_email')) {
                $table->string('guest_email')->nullable()->after('guest_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            if (Schema::hasColumn('reservasi', 'guest_email')) {
                $table->dropColumn('guest_email');
            }

            if (Schema::hasColumn('reservasi', 'guest_name')) {
                $table->dropColumn('guest_name');
            }

            // Revert user_id to not nullable if possible
            if (Schema::hasColumn('reservasi', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            }
        });
    }
};
