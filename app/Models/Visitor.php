<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    /** @use HasFactory<\Database\Factories\VisitorFactory> */
    use HasFactory;

    protected $guarded = [];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class);
    }

    // app/Models/Visitor.php
    public function getCheckinStatusAttribute()
    {
        if (!$this->checked_in_at) return null;

        $diff = $this->checked_in_at->diffInMinutes($this->expected_arrival);

        if ($this->checked_in_at < $this->expected_arrival) {
            return "Early ({$diff} mins)";
        }

        if ($this->checked_in_at > $this->expected_arrival) {
            return "Late ({$diff} mins)";
        }

        return "On Time";
    }

    public function getCheckinStatusColorAttribute()
    {
        if (!$this->checked_in_at) return '';

        if ($this->checked_in_at <= $this->expected_arrival) {
            return 'text-green-600 dark:text-green-400';
        }

        return 'text-red-600 dark:text-red-400';
    }
}
