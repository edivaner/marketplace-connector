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
        Schema::create('offer_images', function (Blueprint $table) {
        $table->id();
        $table->uuid('offer_id');
        $table->string('url');
        $table->timestamps();

        $table->foreign('offer_id')
              ->references('id')
              ->on('offers')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_images');
    }
};
