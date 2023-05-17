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
        Schema::table("decors", function (Blueprint $table){
            $table->string('img_path')->nullable()->change();
        });
        Schema::table("flowers", function (Blueprint $table){
            $table->string('img_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("decors", function (Blueprint $table){
            $table->string('img_path')->change();
        });
        Schema::table("flowers", function (Blueprint $table){
            $table->string('img_path')->change();
        });
    }
};
