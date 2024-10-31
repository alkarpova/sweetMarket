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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUlid('country_id')
                ->after('phone')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignUlid('region_id')
                ->after('country_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignUlid('city_id')
                ->after('region_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('address')
                ->after('city_id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['region_id']);
            $table->dropForeign(['city_id']);

            $table->dropColumn('country_id');
            $table->dropColumn('region_id');
            $table->dropColumn('city_id');
            $table->dropColumn('address');
        });
    }
};
