<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Upload
 * @package App
 *
 * @property integer $id
 * @property integer $size
 * @property integer $views
 * @property string  $name
 * @property string  $content_type
 * @property string  $file
 * @property string  $file_url
 * @property string  $file_path
 *
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 */
class Upload extends Model
{
    use \App\Traits\Upload;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upload';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'file_url',
        'file_path'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'file' => 'image',
    ];

    /**
     * @return array
     */
    public function getUploadSettings()
    {
        return [
            'file' => [
                'resize' => [1024, 768, function ($constraint) {
                    $constraint->upsize();
                }],
            ],
        ];
    }
}
