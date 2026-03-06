<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 *
 * @method static \Database\Factories\PostCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCategory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Post, $this> */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
