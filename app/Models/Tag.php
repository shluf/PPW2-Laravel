<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use HasFactory;
    
    protected $table = 'tag';
    protected $fillable = ['review_id', 'tag'];

    public function reviews()
    {
        return $this->hasMany(ReviewTag::class);
    }
}
