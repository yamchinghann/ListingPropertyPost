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
        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->timestamps();
            $table->foreignIdFor(\App\Models\Listing::class)->constrained('listings');
            //if we didn't specific column name at second of foreignIdFor() then it automatically use
            //listing and plus _id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_images');
    }
};
