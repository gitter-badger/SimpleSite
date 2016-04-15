<?php

namespace App;

use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * Class Photo
 * @package App
 *
 * @property integer       $id
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

    use Upload;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'image',
        'thumb' => 'image',
    ];

    /**
     * @return array
     */
    public function getUploadSettings()
    {
        return [
            'image' => [
                'orientate' => [],
                'resize' => [1280, null, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                }]
            ],
            'thumb' => [
                'orientate' => [],
                'fit' => [200, 300, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                }]
            ]
        ];
    }

    /**
     * @param PhotoCategory $category
     *
     * @throws \Exception
     */
    public function addToCategory(PhotoCategory $category)
    {
        if (! $category->exists) {
            throw new \Exception('Category not exists');
        }

        $this->category()->associate($category);
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param UploadedFile $file
     */
    public function setUploadFileAttribute(UploadedFile $file = null)
    {
        if (is_null($file)) {
            return;
        }

        foreach ($this->getUploadFields() as $field) {
            $this->{$field.'_file'} = $file;
        }
    }

    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(PhotoCategory::class, 'category_id');
    }
}
