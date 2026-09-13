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
        Schema::create('dyelote_mov_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movdetailsid')->constrained('mov_details');
            $table->foreignId('itemid')->constrained('items');
            $table->string('dyelote');
            $table->date('duedate')->nullable();
            $table->string('MSDS')->nullable();
            $table->decimal('qtyxlote', 10, 2);
            $table->decimal('weightxlote', 10, 2)->nullable();
            $table->foreignId('movdetailsid_IN')->nullable()->constrained('mov_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dyelote_mov_details');
    }
};
