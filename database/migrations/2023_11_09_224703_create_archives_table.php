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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->string('overview');
            $table->integer('total_amount_of_donation');
            $table->integer('users_id');
            $table->string('users_name');
            $table->integer('charity_id');
            $table->integer('Beneficiaries_id');
            $table->string('Beneficiaries_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
