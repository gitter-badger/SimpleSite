<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * Class Photo
 * @package App
 *
 * @property string        $caption
 * @property string        $description
 * @property string        $image
 * @property string        $thumb
 *
 * @property string        $image_path
 * @property string        $thumb_path
 *
 * @property string        $image_url
 * @property string        $thumb_url
 *
 * @property integer       $category_id
 * @property PhotoCategory $category
 *
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 */
class Photo extends Model
{

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function (Photo $photo) {
            foreach (['image', 'thumb'] as $key) {
                if (! empty($photo->original[$key]) and file_exists($file_path = public_path($photo->original[$key]))) {
                    unlink($file_path);
                }
            }
        });

        static::deleting(function (Photo $photo) {
            unlink($photo->image_path);
            unlink($photo->thumb_path);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caption',
        'description',
        'upload_file'
    ];

    /**
     * @param PhotoCategory $category
     */
    public function addToCategory(PhotoCategory $category)
    {
        if (! $category->exists) {
            throw new UploadException('Category not exists');
        }

        $this->category()->associate($category);
    }

    /**
     * @param UploadedFile $file
     */
    public function attachFile(UploadedFile $file)
    {
        $destination_path = 'storage';
        $filename         = str_random(6).'_'.$file->getClientOriginalName();

        $subFolder = substr(md5($filename), 0, 2);

        if (! is_dir(public_path($photosDir = $destination_path.'/photos/'.$subFolder))) {
            \File::makeDirectory(public_path($photosDir), 493, true);
        }

        Image::make($file)->resize(1280, 1024)->save(public_path($path = $photosDir.'/'.$filename));
        Image::make($file)->resize(200, 200)->save(public_path($thumbPath = $photosDir.'/thumb_'.$filename));

        $this->image  = $path;
        $this->thumb = $thumbPath;
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (! empty($this->attributes['image'])) {
            return url($this->attributes['image']);
        }
    }

    /**
     * @return string
     */
    public function getThumbUrlAttribute()
    {
        if (! empty($this->attributes['thumb'])) {
            return url($this->attributes['thumb']);
        }
    }

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        if (! empty($this->attributes['image'])) {
            return public_path($this->attributes['image']);
        }
    }

    /**
     * @return string
     */
    public function getThumbPathAttribute()
    {
        if (! empty($this->attributes['thumb'])) {
            return public_path($this->attributes['thumb']);
        }
    }

    /**
     * @param UploadedFile $file
     */
    public function setUploadFileAttribute(UploadedFile $file = null)
    {
        if (is_null($file)) {
            return;
        }

        $this->attachFile($file);
    }

    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo(PhotoCategory::class, 'category_id');
    }
}
