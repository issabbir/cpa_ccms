<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{

    public function getMaintenanceLog() {
        return view('ccms.maintenance_log');
    }


}
