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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->unsignedBigInteger('google_id')->nullable();
            $table->unsignedBigInteger('facebook_id')->nullable();
            $table->text('avatar')->default('https://lineone.piniastudio.com/images/avatar/avatar-19.jpg');
            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('website_link')->nullable();
            $table->enum('status', ['active','disabled'])->default('active');
            $table->enum('presence', ['online', 'offline'])->default('offline');
            $table->tinyInteger('role')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
