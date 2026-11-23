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
        Schema::table('majalis', function (Blueprint $table) {
            if (!Schema::hasColumn('majalis', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('majalis', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
        });

        if (!Schema::hasTable('tadabbur_likes')) {
            Schema::create('tadabbur_likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('tadabbur_id')->constrained('tadabburat')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['user_id', 'tadabbur_id']);
            });
        }

        if (!Schema::hasTable('majlis_histories')) {
            Schema::create('majlis_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('majlis_id')->constrained('majalis')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('action', 50);
                $table->text('old_content')->nullable();
                $table->text('new_content')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majlis_histories');
        Schema::dropIfExists('tadabbur_likes');

        Schema::table('majalis', function (Blueprint $table) {
            if (Schema::hasColumn('majalis', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('majalis', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};








