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
        Schema::create('students', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('roll_no', 15);
            $table->string('name', 50);
            $table->integer('class');
            $table->string('email', 50)->unique();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('guardian_name', 50)->nullable();
            $table->string('guardian_email', 50)->unique();
            $table->string('city', 10)->nullable();
            $table->string('state', 10)->nullable();
            $table->integer('pincode')->nullable();
            $table->char('import_filename',50)->nullable();
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
        Schema::dropIfExists('students');
    }
};
