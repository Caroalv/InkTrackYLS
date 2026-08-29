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
        Schema::create('items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('subgroupid')->constrained('subgroups');
    $table->foreignId('muid')->constrained('measurement_units');
    $table->string('phcode')->nullable();
    $table->string('itemname');
    $table->decimal('unitestimatedweight', 10, 2)->nullable();
    $table->decimal('minstock', 10, 2)->default(0);
    $table->decimal('maxstock', 10, 2)->default(0);
    $table->decimal('currentstock', 10, 2)->default(0);
    $table->decimal('estimatedunitweight', 10, 2)->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
