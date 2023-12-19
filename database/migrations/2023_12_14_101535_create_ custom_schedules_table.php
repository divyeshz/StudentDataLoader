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
        Schema::create('custom_schedules', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->enum('schedule_type', ['class', 'student'])->nullable();
            $table->dateTime('datetime')->nullable();
            $table->string('schedule_value', 15)->nullable();
            $table->string('status', 50)->nullable();
            $table->boolean('is_send')->default(0)->comment('0:false,1:true');
            $table->boolean('is_active')->default(1)->comment('0:Blocked,1:Active');
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_schedules');
    }
};
