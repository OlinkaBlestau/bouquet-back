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
            $table->id()->autoIncrement();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('address');
            $table->string('phone');
            $table->string('password');
            $table->string('role')->default('user');
            $table->timestamps();
        });

        Schema::create('bouquets', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->float('total_price');
            $table->timestamps();
        });

        Schema::create('shops', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('telegram');
            $table->string('instagram');
            $table->string('facebook');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('bouquet_id')->constrained('bouquets')->onDelete('cascade');
            $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::create('flowers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('color');
            $table->float('price');
            $table->integer('storage_flower_amount');
            $table->string('img_path');
            $table->timestamps();
        });

        Schema::create('decors', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('color');
            $table->float('price');
            $table->integer('storage_decor_amount');
            $table->string('img_path');
            $table->timestamps();
        });

        Schema::create('bouquets_flowers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('flower_id')->constrained('flowers')->onDelete('cascade');
            $table->foreignId('bouquet_id')->constrained('bouquets')->onDelete('cascade');
            $table->integer('bouquet_flowers_amount');
            $table->timestamps();
        });

        Schema::create('bouquets_decors', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('decor_id')->constrained('decors')->onDelete('cascade');
            $table->foreignId('bouquet_id')->constrained('bouquets')->onDelete('cascade');
            $table->integer('bouquet_decors_amount');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouquets_flowers');
        Schema::dropIfExists('bouquets_decors');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('bouquets');
        Schema::dropIfExists('users');
        Schema::dropIfExists('shops');
        Schema::dropIfExists('flowers');
        Schema::dropIfExists('decors');
    }
};
