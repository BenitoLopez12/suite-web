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
        Schema::create('data_questions_templates_analisis_riesgo', function (Blueprint $table) {
            $table->id();
            $table->integer('minimum')->nullable();
            $table->integer('maximum')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_questions_templates_analisis_riesgo');
    }
};