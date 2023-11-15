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
        Schema::create('dividable_donations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('full_price');
            $table->integer('charity_id');
            $table->integer('completion_percentage');
            $table->string('priority');
            $table->string('overview');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividable_donations');
    }
};
