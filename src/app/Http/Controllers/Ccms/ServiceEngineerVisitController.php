<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceEngineerVisitController extends Controller
{
    public function getServiceEngineerVisit()
    {
        return view('ccms.service_engineer_visit');
    }
}
