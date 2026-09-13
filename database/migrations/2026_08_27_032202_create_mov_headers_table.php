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
        Schema::create('mov_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctypeid')->constrained('doc_types');
            $table->foreignId('supplierid')->nullable()->constrained('suppliers');
            $table->string('docnumber');
            $table->date('docdate');
            $table->date('YLSindate')->nullable();
            $table->date('SPindate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mov_headers');
    }
};
