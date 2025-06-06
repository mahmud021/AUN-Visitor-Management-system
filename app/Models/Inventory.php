<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded;
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function timelineEvents()
    {
        return $this->hasMany(\App\Models\InventoryTimelineEvent::class);
    }

}
