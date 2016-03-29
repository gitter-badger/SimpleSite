<?php

namespace App;

use App\Helpers\MarkdownParser;
use App\Traits\Authored;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\Facades\Image;

/**
 * Class Post
 * @package App
 *
 * @property integer $id
 * @property integer $author_id
 * @property User    $author
 *
 * @property string  $title
 * @property string  $text_source
 * @property string  $text
 * @property string  $text_intro
 *
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 */
class Post extends Model
{
    use SoftDeletes, Authored;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog';

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
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = trim($title);
    }

    /**
     * @param string $text
     */
    public function setTextSourceAttribute($text)
    {
        $this->attributes['text_source'] = trim($text);

        list($parsedText, $parsedTextIntro) = MarkdownParser::parseText($this->attributes['text_source']);

        $this->attributes['text_intro'] = $parsedTextIntro;
        $this->attributes['text'] = $parsedText;
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
    public function scopeRecent($query, $days = 1)
    {
        return $query->where('created_at', '>', Carbon::now()->subDay($days));
    }

}
