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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_brand');
            $table->tinyInteger('status')->default(0); // 0=new, 1=sale
            $table->unsignedSmallInteger('sale')->default(0); // % giảm
            $table->string('company')->nullable();
            $table->text('image')->nullable(); // JSON string các file ảnh
            $table->longText('detail')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
