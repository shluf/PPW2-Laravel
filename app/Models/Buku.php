<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = ['id', 'judul', 'penulis', 'harga', 'tgl_terbit', 'created_at', 'updated_at', 'filename', 'filepath'];

    protected $casts = [
        'tgl_terbit' => 'date'  
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}


