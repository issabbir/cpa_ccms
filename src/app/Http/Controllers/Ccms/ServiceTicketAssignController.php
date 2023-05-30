<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ServiceTicketAssignManager;
use Illuminate\Http\Request;

class ServiceTicketAssignController extends Controller
{
    public function index(Request $request, ServiceTicketAssignManager $serviceTicketAssignManager)
    {
    	$data = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findOne($request->get('id'));
        $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        $getTicketNo =  $serviceTicketAssignManager->getServiceTicketAssignRepo()->getTicketNo();
        $getServiceEngineerId = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findAllServiceEngineer();
        // dd();
        return view('ccms.service_ticket_assign', compact('data', 'gen_uniq_id', 'getTicketNo', 'getServiceEngineerId'));
    }

    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param ServiceTicketAssignManager $serviceTicketAssignManager
     * @return mixed
     * @throws \Exception
     */

    public function list(Request $request, ServiceTicketAssignManager $serviceTicketAssignManager)
    {
    	return $serviceTicketAssignManager->getServiceTicketAssignTables($request);
    }


    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
       //dd($request);
        $result = $procedureManager->execute('TICKET.SERVICE_TICKET_ASSIGN_CRUD', $request)->getParams();
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('service_ticket.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('ticket_assign.index', ['id' => $id]);

         return redirect()->route('service_ticket.index');
    }
}
