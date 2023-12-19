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
            $table->uuid('file_reference_id')->nullable(); // Foreign key field
            $table->string('roll_no', 15);
            $table->string('name', 50);
            $table->integer('class');
            $table->string('email', 50);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('guardian_name', 50);
            $table->string('guardian_email', 50);
            $table->string('city', 10);
            $table->string('state', 10);
            $table->integer('pincode');
            $table->boolean('is_active')->default(1)->comment('0:Blocked,1:Active');
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->timestamps();

            $table->foreign('file_reference_id')->references('id')->on('file_references')->cascadeOnDelete()->cascadeOnUpdate();
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
