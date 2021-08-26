<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class, 'page_id');
    }
}
