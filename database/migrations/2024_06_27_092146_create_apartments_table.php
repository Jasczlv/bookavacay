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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->smallInteger('rooms');
            $table->smallInteger('beds');
            $table->smallInteger('bathrooms');
            $table->smallInteger('sqr_mt');
            $table->decimal('lat', 8, 5);
            $table->decimal('long', 9, 5);
            $table->string('image');
            $table->boolean('visible')->default(false);
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
