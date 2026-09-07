<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'public_key', 'secret_key',
        'webhook_secret', 'mode', 'is_active', 'official_url',
        'extra_settings',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'extra_settings' => 'array',
    ];

    protected $hidden = [
        'secret_key', 'webhook_secret',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOnline($query)
    {
        return $query->where('type', 'online');
    }

    public function isLive(): bool
    {
        return $this->mode === 'live';
    }
}
