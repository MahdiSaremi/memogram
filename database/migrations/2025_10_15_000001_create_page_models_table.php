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
        Schema::create(config('memogram.database.pages'), function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->json('states');
            $table->string('states_hash');

            $table->unique(['reference', 'states_hash']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('memogram.database.pages'));
    }
};
