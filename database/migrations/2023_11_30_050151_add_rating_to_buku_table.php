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
        Schema::table('buku', function (Blueprint $table) {
            $table->integer('rating_1')->default(0);
            $table->integer('rating_2')->default(0);
            $table->integer('rating_3')->default(0);
            $table->integer('rating_4')->default(0);
            $table->integer('rating_5')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('rating_1');
            $table->dropColumn('rating_2');
            $table->dropColumn('rating_3');
            $table->dropColumn('rating_4');
            $table->dropColumn('rating_5');
        });
    }
};