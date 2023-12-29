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
            $table->string('type');
            $table->integer('total_cost');
            $table->integer('charity_id');
            $table->integer('amount_paid');
            $table->string('priority');
            $table->string('overview');
            $table->timestamp('expriation_date');
            $table->boolean('status');
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
