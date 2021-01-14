<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Class SeoBlock
 * @package App\Models
 *
 * @property-read int id
 * @property string|null title
 * @property string|null description
 * @property-read int model_id
 * @property-read string model_type
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read ArticleCategory category
 *
 * @mixin Eloquent
 */
class SeoBlock extends Model
{
    use HasTranslations;

    public $translatable = [
        'title', 'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];
}
