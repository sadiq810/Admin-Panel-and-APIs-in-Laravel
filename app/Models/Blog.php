<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $table = 'articles';
    protected $guarded = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(BlogTranslation::class, 'article_id', 'id');
    }
}
