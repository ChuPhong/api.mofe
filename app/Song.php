<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Song
 *
 * @property int $id
 * @property string $name
 * @property string|null $otherName
 * @property string $thumbnail
 * @property string $url
 * @property int $year
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artist[] $artists
 * @property-read int|null $artists_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Song whereYear($value)
 * @mixin \Eloquent
 * @property string|null $other_name
 * @property-read mixed $slug
 */
class Song extends Model
{
    protected $fillable = ['name', 'other_name', 'url', 'thumbnail', 'year', 'views'];

    public function artists() {
        return $this->belongsToMany('App\Artist');
    }

    public function setArtist(...$artists) {
        $artists = collect($artists)
            ->flatten()
            ->map(function ($artist) {
                if (empty($artist)) {
                    return false;
                }
                return Artist::whereName($artist)->first();
            })
            ->filter(function ($artist) {
                return $artist instanceof Artist;
            })
            ->map->id
            ->all();

        $this->artists()->sync($artists);

        return $this;
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }

    public function scopeSearch($query, $name) {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        return $query->where('name', 'LIKE', "%$name%")
                    ->orWhere('other_name', 'LIKE', "%$name%")
                    ->orWhereHas('artists', function ($query) use ($name) {
                        /** @var \Illuminate\Database\Eloquent\Builder $query */
                        return $query->where('name', 'LIKE', "%$name%");
                    });
    }
}
