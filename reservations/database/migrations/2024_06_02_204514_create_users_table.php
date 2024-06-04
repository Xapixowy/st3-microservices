<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('status');
            $table->foreignId('restaurant_id');
            $table->foreignId('table_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_reservations');
    }
};
