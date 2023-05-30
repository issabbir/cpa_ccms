<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequisitionLogController extends Controller
{
    public function getRequisitionLog()
    {
        return view('ccms.requisition_log');
    }
}
