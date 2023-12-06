<?php
// app/Models/Buku.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = "buku";
    protected $fillable = [
        'id',
        'judul',
        'penulis',
        'harga',
        'tgl_terbit',
        'created_at', 
        'updated_at', 
        'filename', 
        'filepath',
        'rating_1',
        'rating_2',
        'rating_3',
        'rating_4',
        'rating_5',
        'sum_rating', // Tambahkan kolom sum_rating
    ];
    
    protected $casts = [
        'tgl_terbit' => 'date'
    ];

    protected $dates = ['tgl_terbit'];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Calculate and store the sum of ratings.
     */
    

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
}
