<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $guarded = [];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

    // تفعيل الأعمدة المخصصة للحزمة وتخزينها
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'hotel_name',
            'email',
            'password',
            'trial_ends_at',
            'subscription_status',
        ];
    }
}
