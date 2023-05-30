<?php

namespace App\Http\Controllers\Ccms;


use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Entities\Ccms\VendorList;
use App\Entities\Ccms\VendorContactPerson;

use App\Managers\Ccms\EquipmentListManager;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use App\Managers\ProcedureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function employeeList(Request $request, EmployeeContract $employeeManager) {
        return $employeeManager->findEmployeesWithNameBy($request->get('term'));
    }
}
