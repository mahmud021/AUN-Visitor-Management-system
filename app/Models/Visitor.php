<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    /** @use HasFactory<\Database\Factories\VisitorFactory> */
    use HasFactory;

    protected $casts = [
        'visit_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    protected $guarded = [ ];


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function timelineEvents()
    {
        return $this->hasMany(TimelineEvent::class);
    }
}
