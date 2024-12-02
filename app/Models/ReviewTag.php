<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewTag extends Model
{
    use HasFactory;

    protected $table = 'review_tag';
    protected $fillable = ['review_id', 'tag_id'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
