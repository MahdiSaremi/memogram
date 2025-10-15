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
        Schema::create(config('memogram.database.page_cells'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('use_id')
                ->constrained(config('memogram.database.page_uses'), 'id')
                ->cascadeOnDelete();
            $table->bigInteger('message_id')->nullable()->index();
            $table->string('key')->index();
            $table->boolean('is_taking_control');

            $table->unique(['use_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('memogram.database.page_cells'));
    }
};
