<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getUserWiseEquipment()
    {
        return view('ccms.report.user_wise_equipment_report');
    }

    public function getServiceTicket()
    {
        return view('ccms.report.maintenance_service_ticket_report');
    }

    public function getServiceEngineer()
    {
        return view('ccms.report.service_engineer_list');
    }

    public function getVendorList()
    {
        return view('ccms.report.vendor_list_report');
    }

    public function getEquipmentMaintenance()
    {
        return view('ccms.report.equipment_maintenance_report');
    }

    public function getEquipmentList()
    {
        return view('ccms.report.equipment_list_report');
    }
}
