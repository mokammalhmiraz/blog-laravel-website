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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // Foreign key to the users table
            $table->string('image')->nullable(); // Profile image (optional)
            $table->string('name');              // Profile name
            $table->string('mail');              // Profile mail (possibly redundant if it's same as user's email)
            $table->string('profession')->nullable(); // Profile image (optional)
            $table->text('address')->nullable(); // Optional address
            $table->text('intro')->nullable();    // Optional additional info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
