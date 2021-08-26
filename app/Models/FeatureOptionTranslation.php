<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureOptionTranslation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feature_option_translations';

    protected $guarded = ['id'];

    public function option(): BelongsTo
    {
        return $this->belongsTo(FeatureOption::class, 'feature_option_id', 'id');
    }
}
