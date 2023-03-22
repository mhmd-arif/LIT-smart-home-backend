<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DeviceUsage;
use App\Models\Device;

class Device extends Model
{
    use HasFactory;

    public $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deviceUsage(): HasMany
    {
        return $this->hasMany(DeviceUsage::class);
    }

}
