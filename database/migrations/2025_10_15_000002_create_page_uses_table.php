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
        Schema::create(config('memogram.database.page_uses'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')
                ->constrained(config('memogram.database.pages'), 'id')
                ->cascadeOnDelete();
            $table->bigInteger('chat_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('memogram.database.page_uses'));
    }
};
