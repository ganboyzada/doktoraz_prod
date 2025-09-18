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
        Schema::table('orders', function (Blueprint $table) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('ig_username')->nullable()->after('customer_phone');
                $table->string('country')->after('ig_username');
                $table->enum('has_custom_logo', ['yes','no','not_yet_ready'])->default('no')->after('country');
                $table->enum('payment_method', ['bank', 'cash', 'card'])->after('has_custom_logo');
                $table->boolean('terms_accepted')->default(false)->after('payment_method');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'ig_username',
                'country',
                'has_custom_logo',
                'payment_method',
                'terms_accepted',
            ]);
        });
    }
};
