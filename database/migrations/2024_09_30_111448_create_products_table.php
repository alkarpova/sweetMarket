<?php

use App\Enums\ProductStatus;
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
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('country_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('region_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('city_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('category_id')->constrained()->cascadeOnDelete();
            $table->string('name')->index();
            $table->string('image')->nullable();
            $table->decimal('price', 15, 4)->default(0);
            $table->integer('minimum')->default(1);
            $table->integer('maximum')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('weight', 15, 4)->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(ProductStatus::Draft->value)->index();
            $table->timestamps();
            $table->softDeletes();
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
