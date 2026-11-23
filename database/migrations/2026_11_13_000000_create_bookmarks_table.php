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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 20)->default('majlis'); // 'majlis', 'surah', 'ayah'
            $table->foreignId('majlis_id')->nullable()->constrained('majalis')->cascadeOnDelete();
            $table->unsignedSmallInteger('surah_number')->nullable();
            $table->unsignedSmallInteger('ayah_number')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
