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
        Schema::create('gallery_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type')->default('photo');
            $table->integer('title')->nullable();
            $table->integer('media')->nullable();
            $table->string('link')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_posts');
    }
};
