<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTimelineEvent extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryTimelineEventFactory> */
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'user_id',
        'event_type',
        'description',
        'details',
        'occurred_at',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
