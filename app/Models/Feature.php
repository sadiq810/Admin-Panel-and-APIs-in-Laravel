<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(FeatureTranslation::class, 'feature_id', 'id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(FeatureOption::class, 'feature_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(FeatureItem::class, 'feature_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }
}
