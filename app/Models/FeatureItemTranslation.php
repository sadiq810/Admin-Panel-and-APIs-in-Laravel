<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureItemTranslation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feature_item_translations';

    protected $guarded = ['id'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(FeatureItem::class, 'feature_item_id', 'id');
    }
}
