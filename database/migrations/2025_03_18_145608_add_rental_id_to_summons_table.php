<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('summons', function (Blueprint $table) {
            // If officer_id exists, drop it first
            if (Schema::hasColumn('summons', 'officer_id')) {
                $table->dropForeign(['officer_id']);
                $table->dropColumn('officer_id');
            }

            // If offender_id exists, drop it first
            if (Schema::hasColumn('summons', 'offender_id')) {
                $table->dropForeign(['offender_id']);
                $table->dropColumn('offender_id');
            }

            // Add rental_id
            $table->foreignId('rental_id')->after('summons_number')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('summons', function (Blueprint $table) {
            $table->dropForeign(['rental_id']);
            $table->dropColumn('rental_id');
        });
    }
};