<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceEngineerAssignController extends Controller
{
    public function getServiceEngineerAssignment()
    {
        return view('ccms.service_engineer_assignment');
    }
}
