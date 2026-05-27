<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->string('room_number');
            $table->string('type')->default('standard');
            $table->decimal('price_per_night', 10, 2);
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->boolean('is_available')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
            
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};