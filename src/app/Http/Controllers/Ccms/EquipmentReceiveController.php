<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\EquipmentReceiveManager;
use Illuminate\Http\Request;

class EquipmentReceiveController extends Controller
{
    public function index(Request $request, EquipmentReceiveManager $equipmentReceiveManager)
    {
    	$data = $equipmentReceiveManager->getEquipmentReceiveRepo()->findOne($request->get('id'));
    	$getTicketNo = $equipmentReceiveManager->getEquipmentReceiveRepo()->findAllServiceTicket();
    	$getEquipmentNo = $equipmentReceiveManager->getEquipmentReceiveRepo()->findAllEquipmentList();
    	$getServiceEngineerId = $equipmentReceiveManager->getEquipmentReceiveRepo()->findAllServiceEngineer();
    	$gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        return view('ccms.service_equipment_receive',
        	compact('data', 'gen_uniq_id', 'getTicketNo', 'getEquipmentNo', 'getServiceEngineerId'));
    }


    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param EquipmentReceiveManager $serviceTicketManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, EquipmentReceiveManager $equipmentReceiveManager) {
        return $equipmentReceiveManager->getEquipmentReceiveTables($request);
    }



    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        $result = $procedureManager->execute('TICKET.SERVICE_EQUIPMENT_RECEIVE_CRUD', $request)->getParams();
        // dd($result);
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('equipment_receive.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('equipment_receive.index', ['id' => $id]);

         return redirect()->route('equipment_receive.index');
    }
}
