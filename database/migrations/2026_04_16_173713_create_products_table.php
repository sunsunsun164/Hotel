<?php

use App\Models\Hotel;
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
        Schema::create('products', function (Blueprint $table) {
            $table->ulid();

            $table->string('name');
            $table->text('description')->nullable();
            $table->float('price');

            $table->bigInteger('hotel_id');

            $table->foreign('hotel_id')
                ->references('id')
                ->on('hotels')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->index('hotel_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
