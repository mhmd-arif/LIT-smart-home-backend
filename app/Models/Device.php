<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use App\Models\User;
use App\Models\DeviceUsage;
use App\Models\UserDevice;


class Device extends Model
{
    use HasFactory;

    public $guarded = [];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function deviceUsage(): HasMany
    // {
    //     return $this->hasMany(DeviceUsage::class);
    // }

    public function userDevice(): HasMany
    {
        return $this->hasMany(UserDevice::class);
    }

}
