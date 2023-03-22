<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TotalUsage;
use Carbon\Carbon;

class TotalUsageController extends Controller
{
    public function getTotalUsage()
    {
        $total_usages = DB::table('total_usages')->get();
        return response()->json($total_usages);
    }
}

