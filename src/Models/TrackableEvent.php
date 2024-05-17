<?php

namespace EventTracker\Models;

use Illuminate\Database\Eloquent\Model;

class TrackableEvent extends Model
{
    protected $table = 'trackable_events';

    protected $fillable = [
        'event_name',
        'user_id',
        'tracked_model_id',
        'tracked_model_type',
        'value',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function trackedModel()
    {
        return $this->morphTo();
    }
}
