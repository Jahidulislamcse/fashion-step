<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fabric_barcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_id')->constrained('fabrics')->onDelete('cascade');
            $table->string('barcode_value')->unique();
            $table->foreignId('generated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fabric_barcodes');
    }
};

