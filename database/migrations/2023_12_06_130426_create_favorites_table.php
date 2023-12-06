<?php
// database/migrations/xxxx_xx_xx_create_favorites_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            
            // Foreign key untuk user_id
            $table->foreignId('user_id')->constrained('users');

            // Foreign key untuk buku_id
            $table->foreignId('buku_id')->constrained('buku');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
