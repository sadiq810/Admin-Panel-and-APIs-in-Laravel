<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $table = 'faqs';
    protected $guarded = ['id'];

    /**
     * @return HasOne
     */
    public function translations(): HasOne
    {
        return $this->hasOne(FaqTranslation::class, 'faq_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     * Active scope.
     */
    public function scopeActive($query): mixed
    {
        return $query->where('status', 1);
    }

    /**
     * @param $query
     * @return mixed
     * Active scope.
     */
    public function scopeSorted($query): mixed
    {
        return $query->orderBy('order', 'asc');
    }
}
