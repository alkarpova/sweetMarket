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
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('country_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('region_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('city_id')->constrained()->cascadeOnDelete();
            $table->string('number')->unique()->index();
            $table->string('shipping_address');
            $table->decimal('total', 15, 4);
            $table->text('notes')->nullable();
            $table->string('status')->default(\App\Enums\OrderStatus::Pending->value)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};