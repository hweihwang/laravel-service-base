<?php

namespace Modules\Product\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $shared_url
 * @property ?string $description
 * @property Carbon $created_at
 * @property ?Carbon $updated_at
 */
final class Tag extends Model
{
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
