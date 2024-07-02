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
            $table->smallInteger('rooms'); //Potrebbero anche essere tinyInt oppure unsignedSmallInteger
            $table->smallInteger('beds');
            $table->smallInteger('bathrooms');
            $table->smallInteger('sqr_mt');
            $table->string('address');
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('image')->nullable();
            $table->boolean('visible')->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('apartments');
        Schema::table('flights', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
