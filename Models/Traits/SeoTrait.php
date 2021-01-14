<?php

namespace App\Models\Traits;

use App\Models\SeoBlock;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Trait SeoTrait
 * @package App\Models\Traits
 *
 * @property-read SeoBlock|null seo
 */
trait SeoTrait
{
    /**
     * Relationship to seo block
     *
     * @return MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(SeoBlock::class, 'model', 'model_type', 'model_id');
    }
}
