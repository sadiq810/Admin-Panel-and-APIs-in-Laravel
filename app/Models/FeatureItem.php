<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feature_items';

    protected $guarded = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(FeatureItemTranslation::class, 'feature_item_id', 'id');
    }
}
