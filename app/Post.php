<?php

namespace App;

use App\Helpers\MarkdownParser;
use App\Traits\Authored;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

/**
 * Class Post
 * @package App
 *
 * @property integer                    $id
 * @property integer                    $author_id
 * @property User                       $author
 *
 * @property string                     $title
 * @property string                     $text_source
 * @property string                     $text
 * @property string                     $text_intro
 *
 * @property string                     $image
 * @property string                     $thumb
 * @property string                     $image_path
 * @property string                     $thumb_path
 * @property string                     $image_url
 * @property string                     $thumb_url
 *
 * @property PhotoCategory[]|Collection $photo_categories
 *
 * @property Carbon                     $created_at
 * @property Carbon                     $updated_at
 * @property Carbon                     $deleted_at
 */
class Post extends Model
{

    use SoftDeletes, Authored, Upload;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text_source',
        'title',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'upload',
        'thumb' => 'upload',
    ];

    /**
     * @var array
     */
    protected $uploadSettings = [
        'image' => [
            'resize' => [640, 480],
        ],
        'thumb' => [
            'resize' => [150, 150],
        ],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'text_source',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string $title
     */
    public function setTitleAttribute(string $title)
    {
        $this->attributes['title'] = trim($title);
    }

    /**
     * @param string $text
     */
    public function setTextSourceAttribute(string $text)
    {
        $this->attributes['text_source'] = trim($text);

        list($parsedText, $parsedTextIntro) = MarkdownParser::parseText($this->attributes['text_source']);

        $this->attributes['text_intro'] = $parsedTextIntro;
        $this->attributes['text'] = $parsedText;
    }

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
     * Scopes
     **********************************************************************/

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @param     $query
     * @param int $days
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, int $days = 1)
    {
        return $query->where('created_at', '>', Carbon::now()->subDay($days));
    }

    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function photo_categories()
    {
        return $this->belongsToMany(PhotoCategory::class);
    }
}
