<?php

namespace App;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App
 *
 * @property string $title
 * @property string $type
 * @property string $type_title
 * @property string $description
 * @property string $color
 * @property int    $user_id
 * @property User   $user
 *
 * @property string $start
 * @property string $end
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $start_at
 * @property Carbon $end_at
 */
class Calendar extends Model
{
    use Filterable;

    const TYPE_MISSED = 'missed';
    const TYPE_VACATION = 'vacation';
    const TYPE_BUSINESS_TRIP = 'business_trip';
    const TYPE_OTHER = 'other';

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            static::TYPE_MISSED => trans('core.calendar.type.'.static::TYPE_MISSED),
            static::TYPE_VACATION => trans('core.calendar.type.'.static::TYPE_VACATION),
            static::TYPE_BUSINESS_TRIP => trans('core.calendar.type.'.static::TYPE_BUSINESS_TRIP),
            static::TYPE_OTHER => trans('core.calendar.type.'.static::TYPE_OTHER),
        ];
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calendar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'type',
        'start_at',
        'end_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'start',
        'end',
        'title',
        'color'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_at', 'end_at'];

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @return Carbon
     */
    public function getTypeTitleAttribute()
    {
        return trans('core.calendar.type.'.$this->type);
    }

    /**
     * @return Carbon
     */
    public function getTitleAttribute()
    {
        return "[{$this->user->display_name}] [{$this->type_title}] {$this->description}";
    }

    /**
     * @return Carbon
     */
    public function getStartAttribute()
    {
        return $this->start_at->toIso8601String();
    }

    /**
     * @return Carbon
     */
    public function getColorAttribute()
    {
        switch ($this->type) {
            case static::TYPE_VACATION:
                return '#f2711c';
            case static::TYPE_MISSED:
                return '#db2828';
            case static::TYPE_BUSINESS_TRIP:
                return '#2185d0';
            default:
                return '#838383';
        }
    }

    /**
     * @return Carbon
     */
    public function getEndAttribute()
    {
        return $this->end_at->toIso8601String();
    }

    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
