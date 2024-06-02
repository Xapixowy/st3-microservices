<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->string('alpha2', 2)->nullable()->unique();
            $table->string('alpha3', 3)->nullable()->unique();
            $table->string('numeric', 3)->unique();
            $table->string('license_plate', 3)->nullable()->unique();
            $table->string('domain', 3)->nullable()->unique();
            $table->boolean('isComplete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
