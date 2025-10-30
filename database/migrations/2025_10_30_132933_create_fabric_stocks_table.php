<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fabric_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_id')->constrained('fabrics')->onDelete('cascade');
            $table->enum('transaction_type', ['in', 'out']);
            $table->integer('quantity');
            $table->string('reference')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fabric_stocks');
    }
};
