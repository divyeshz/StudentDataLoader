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
            $table->integer('Maths');
            $table->integer('Science');
            $table->integer('Hindi');
            $table->integer('English');
            $table->integer('Social');
            $table->integer('Computer');
            $table->integer('Arts');
            $table->integer('percentage');
            $table->integer('percentile');
            $table->integer('percentile');
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