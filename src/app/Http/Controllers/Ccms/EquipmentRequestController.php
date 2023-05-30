<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentRequestController extends Controller
{
    public function getEquipmentRequest()
    {
        return view('ccms.equipment_request');
    }
}
