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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('run')->nullable(false)->index();
            $table->string('category')->nullable(false)->index();
            $table->integer('rank')->nullable(false);
            $table->string('title')->nullable(false);
            $table->integer('price')->nullable(false);
            $table->string('imageUrl')->nullable(false);
            $table->decimal('stars', 2, 1)->nullable(false);
            $table->integer('ratings')->nullable(false);
            $table->string('url')->nullable(false);
            $table->timestamps();
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
