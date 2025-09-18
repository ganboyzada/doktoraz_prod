<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('name');
            $table->string('slug');
            $table->integer('description')->nullable();
            $table->string('photos')->nullable();
            $table->boolean('featured')->default(false);
            $table->double('price')->default(0);
            $table->double('discount')->default(0)->nullable();
            $table->boolean('discount_toggle')->default(false);
            $table->integer('quantity')->default(0);
            $table->boolean('out_of_stock')->default(false);
            $table->integer('meta_tags');
            $table->integer('meta_desc');
            $table->foreignIdFor(Category::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
