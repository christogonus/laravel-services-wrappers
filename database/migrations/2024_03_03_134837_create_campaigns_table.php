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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('number')->default(1);
            $table->foreignId('prompt_id')->constrained();
            $table->json('social_handles')->nullable();
            $table->string('niche');
            $table->string('product');
            $table->string('feature');
            $table->string('feature_image')->nullable();
            $table->text('cta')->nullable();
            $table->string('discount')->nullable();
            $table->string('date')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
