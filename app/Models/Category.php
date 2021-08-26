<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     * Active scope.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @param $query
     * @return mixed
     * sorting scope.
     */
    public function scopeSorted($query)
    {
        return $this->orderBy('order', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function translation()
    {
        if (app()->getLocale()) {
            $lang_id = Language::where('code', app()->getLocale())->value('id');
            return $this->hasOne(CategoryTranslation::class, 'category_id', 'id')->where('language_id', $lang_id);
        }//..... end if() .....//

        return $this->hasOne(CategoryTranslation::class, 'category_id', 'id');
    }
}
