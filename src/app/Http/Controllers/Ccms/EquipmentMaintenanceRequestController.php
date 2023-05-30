<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentMaintenanceRequestController extends Controller
{

    public function getEuipmentMaintenanceRequest() {
        return view('ccms.equipment_maintenance_request');
    }


}
