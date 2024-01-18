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
        Schema::create('needs', function (Blueprint $table) {
            $table->id();
            $table->String('name_of_proudct');
            $table->string('type_of_proudct');
            $table->string('needs_type');
            $table->string('image');
            $table->integer('charity_id');
            $table->integer('total_count');
            $table->integer('available_count');
            $table->integer('price_per_item');
            $table->integer('total_amount');
            $table->string('overview');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needs');
    }
};
