<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class DeviceUsage extends Model
{
    use HasFactory;
    
    public $guarded = [];
    public $timestamps = false;

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
