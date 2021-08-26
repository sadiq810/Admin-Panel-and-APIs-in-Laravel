<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
    protected $table = 'faq_translations';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faq_id', 'id');
    }
}
