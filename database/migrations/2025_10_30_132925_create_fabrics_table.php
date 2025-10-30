<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('fabric_no');
            $table->string('composition');
            $table->integer('gsm');
            $table->integer('qty')->default(0);
            $table->string('cuttable_width');
            $table->enum('production_type', ['Sample Yardage','SMS','Bulk']);
            $table->string('construction')->nullable();
            $table->string('color_pantone_code')->nullable();
            $table->string('weave_type')->nullable();
            $table->string('finish_type')->nullable();
            $table->string('dyeing_method')->nullable();
            $table->string('printing_method')->nullable();
            $table->integer('lead_time')->nullable();
            $table->integer('moq')->nullable();
            $table->decimal('shrinkage',5,2)->nullable();
            $table->text('remarks')->nullable();
            $table->string('fabric_selected_by')->nullable();
            $table->string('image_path')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fabrics');
    }
};
