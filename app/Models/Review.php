<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';
    protected $fillable = ['buku_id', 'reviewer_id', 'review'];
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
        
    public function tags()
    {
        return $this->hasMany(ReviewTag::class);
    }
}
