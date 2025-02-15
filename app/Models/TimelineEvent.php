<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * Get the user who performed the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
