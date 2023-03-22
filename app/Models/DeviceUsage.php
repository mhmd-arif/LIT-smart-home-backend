<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
use Illuminate\Database\Eloquent\Relations\belongsTo;

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
