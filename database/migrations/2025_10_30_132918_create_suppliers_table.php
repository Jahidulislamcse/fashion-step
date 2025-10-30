<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('company_name');
            $table->string('code')->unique();
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('rep_name')->nullable();
            $table->string('rep_email')->nullable();
            $table->string('rep_phone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('suppliers');
    }
};

