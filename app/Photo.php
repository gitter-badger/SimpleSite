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
 * @property string        $file
 * @property string        $thumb
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

        static::deleting(function (Photo $photo) {
            unlink(public_path($photo->file));
            unlink(public_path($photo->thumb));
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
        $filename = str_random(6).'_'.$file->getClientOriginalName();

        $subFolder = substr(md5($filename), 0, 2);

        if (! is_dir(public_path($photosDir = $destination_path.'/photos/'.$subFolder))) {
            \File::makeDirectory(public_path($photosDir), 493, true);
        }

        Image::make($file)->resize(1280, 1024)->save(public_path($path = $photosDir.'/'.$filename));
        Image::make($file)->resize(200, 200)->save(public_path($thumbPath = $photosDir.'/thumb_'.$filename));

        $this->file = $path;
        $this->thumb = $thumbPath;
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string $file
     *
     * @return string
     */
    public function getFileAttribute($file)
    {
        return url($file);
    }
    
    /**
     * @param string $thumb
     *
     * @return string
     */
    public function getThumbAttribute($thumb)
    {
        return url($thumb);
    }

    /**
     * @param UploadedFile $file
     */
    public function setUploadFileAttribute(UploadedFile $file)
    {
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
