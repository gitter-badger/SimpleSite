<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhotoCategory
 * @package App
 *
 * @property integer            $id
 * @property string             $title
 * @property string             $description
 * @property string             $thumb_url
 *
 * @property Photo[]|Collection $photos
 * @property Photo              $photo
 *
 * @property Carbon             $created_at
 * @property Carbon             $updated_at
 */
class PhotoCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @return string
     */
    public function getThumbUrlAttribute()
    {
        return $this->photo->thumb_url;
    }


    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photo()
    {
        return $this->hasOne(Photo::class, 'category_id')->orderByRaw('rand()');
    }

    /**********************************************************************
     * Scopes
     **********************************************************************/

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotEmpty($query)
    {
        return $query->has('photos');
    }
}
