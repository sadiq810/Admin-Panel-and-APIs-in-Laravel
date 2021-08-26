<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslation extends Model
{
    use SoftDeletes;

    protected $table = 'category_translations';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
      return  $this->belongsTo(Category::class,'category_id', 'id');
    }
}
