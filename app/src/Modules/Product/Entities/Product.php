<?php

namespace Modules\Product\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Product\Enums\FrontDisplay;

/**
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $shared_url
 * @property int $brand_id
 * @property string|null $short_description
 * @property FrontDisplay $front_display
 * @property bool $is_predicted
 * @property ?array $images
 * @property ?array $videos
 * @property ?string $youtube_video
 * @property Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * Relations
 * @property Collection $tags
 */
final class Product extends Model
{
    protected $casts = [
        'front_display' => FrontDisplay::class,
        'images' => 'array',
        'videos' => 'array',
    ];
    
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
