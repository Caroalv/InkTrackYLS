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
        Schema::create('mov_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('headerid')->constrained('mov_headers')->onDelete('cascade');
            $table->foreignId('itemid')->constrained('items');
            $table->decimal('qty', 10, 2);
            $table->decimal('realweight', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mov_details');
    }
};
