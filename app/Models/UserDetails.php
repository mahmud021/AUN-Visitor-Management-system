<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetails extends Model
{
    /** @use HasFactory<\Database\Factories\UserDetailsFactory> */
    use HasFactory;

    const STATUS_INACTIVE = 'Inactive';
    const STATUS_ACTIVE = 'Enrolled';
    const STATUS_GRADUATED = 'Graduated';

    // Optionally, define a method to return all statuses with labels
    public static function getStatuses(): array
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Enrolled',
            self::STATUS_GRADUATED => 'Graduated',
        ];
    }

    const ROLE_STAFF = 'Staff';
    const ROLE_STUDENT = 'Student';
    const ROLE_HR_ADMIN = 'HR Admin';
    const ROLE_SECURITY = 'Security';

    // Optionally, define a method to return all roles with labels
    public static function getRoles(): array
    {
        return [
            self::ROLE_STAFF => 'Staff',
            self::ROLE_STUDENT => 'Student',
            self::ROLE_HR_ADMIN => 'HR Admin',
            self::ROLE_SECURITY => 'Security',
        ];
    }

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
