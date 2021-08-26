<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feature_options';

    protected $guarded = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(FeatureOptionTranslation::class, 'feature_option_id', 'id');
    }
}
