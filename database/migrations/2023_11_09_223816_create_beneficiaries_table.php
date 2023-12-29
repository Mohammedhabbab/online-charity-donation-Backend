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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mother_name');
            $table->integer('age');
            $table->string('gender');
            $table->integer('phone_number');
            $table->string('address');
            $table->string('needy_type');
            $table->String('monthly_need')->nullable();
            $table->String('name_of_school')->nullable();
            $table->String('Educational_level')->nullable();
            $table->integer('charity_id');
            $table->string('overview');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
