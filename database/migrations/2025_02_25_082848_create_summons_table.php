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
        Schema::create('summons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('summons_number')->unique();
            $table->foreignId('offender_id')->constrained();
            $table->foreignId('officer_id')->constrained();
            $table->foreignId('violation_id')->constrained();
            $table->dateTime('issue_datetime');
            $table->string('location');
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->text('comments')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('status_id')->constrained();
            $table->date('due_date');
            $table->string('photo_evidence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summons');
    }
};
