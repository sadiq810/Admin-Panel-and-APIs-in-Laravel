<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTranslation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'article_translations';
    protected $guarded = ['id'];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'article_id', 'id');
    }
}
