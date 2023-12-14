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
        Schema::create('results', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->uuid('std_id');
            $table->integer('maths');
            $table->integer('science');
            $table->integer('hindi');
            $table->integer('english');
            $table->integer('social_science');
            $table->integer('computer');
            $table->integer('arts');
            $table->integer('total')->default(0);
            $table->decimal('percentage', 8, 2)->default(0);
            $table->char('status',50)->nullable();
            $table->char('created_by', 36)->nullable(); // Create By Wich User
            $table->char('updated_by', 36)->nullable(); // Update By Wich User
            $table->char('deleted_by', 36)->nullable(); // Delete By Wich User
            $table->timestamps();

            $table->foreign('std_id')->references('id')->on('students')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
