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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('category_type');
            $table->string('tag')->nullable();
            $table->string('icon');
            $table->string('title');
            $table->double('price');
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('duration');
            $table->text('properties');
            $table->enum('status',['active','disabled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
