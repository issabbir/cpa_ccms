<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceEngineerController extends Controller
{

    public function getServiceEngineer() {
        return view('ccms.service_engineer');
    }


}
