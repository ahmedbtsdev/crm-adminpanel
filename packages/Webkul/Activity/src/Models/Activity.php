<?php

namespace Webkul\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\UserProxy;
use Webkul\Lead\Models\LeadProxy;
use Webkul\Activity\Contracts\Activity as ActivityContract;

class Activity extends Model implements ActivityContract
{
    /**
     * Define table name of property
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * Define relationships that should be touched on save
     *
     * @var array
     */
    protected $with = [
        'file',
        'user',
    ];

    /**
     * Cast attributes to date time
     *
     * @var array
     */
    protected $casts = [
        'schedule_from' => 'datetime',
        'schedule_to'   => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'type',
        'location',
        'comment',
        'additional',
        'schedule_from',
        'schedule_to',
        'is_done',
        'user_id',
    ];

    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * The participants that belong to the activity.
     */
    public function participants()
    {
        return $this->hasMany(ParticipantProxy::modelClass());
    }

    /**
     * Get the file associated with the activity.
     */
    public function file()
    {
        return $this->hasOne(FileProxy::modelClass(), 'activity_id');
    }

    /**
     * The leads that belong to the activity.
     */
    public function leads()
    {
        return $this->belongsToMany(LeadProxy::modelClass(), 'lead_activities');
    }
}
