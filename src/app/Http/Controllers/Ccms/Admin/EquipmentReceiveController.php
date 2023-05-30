<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Entities\Ccms\EquipmentReceive;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAddManager;
use App\Managers\Ccms\EquipmentListManager;
use Illuminate\Support\Facades\Auth;
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
        return view('ccms.admin.manage_equipment.service_equipment_receive',
        	compact('data', 'gen_uniq_id', 'getTicketNo', 'getEquipmentNo', 'getServiceEngineerId'));
    }

    public function detail(Request $request, EquipmentListManager $equipmentListManager, EquipmentReceiveManager $equipmentReceiveManager ){
        $getEquipmentReceiveDtl = $equipmentReceiveManager->getEquipmentReceiveRepo()->findOne($request->get('id'));
//        $equipment_add_no = $request->get('id');
        return view('ccms.admin.manage_equipment.equipment_receive_dtl', compact('getEquipmentReceiveDtl'));
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

    public function downloadReceiveFile(Request $request, $id)
    {
        $docData = EquipmentReceive::find($id);//dd($docData);

        if ($docData) {
            if ($content = $docData->received_doc) {
                $arr = explode(',', $content);
                $base64 = $arr[1];
                $arr2 = explode("/", $arr[0]);
                $typeA = explode(";", $arr2[1]);
                $file = str_replace("data:","",$arr2[0]);
                $type = $typeA[0];
               // die();
                return response()->make(base64_decode($base64), 200, [
                    'Content-Type' => "$file/$type",
                    'Content-Disposition' => 'attachment; filename="Receive_'.$id.".$type"
                ]);
            }
        }
    }

    public function downloadDeliveryFile(Request $request, $id)
    {
        $docData = EquipmentReceive::find($id);//dd($docData);

        if ($docData) {
            if ($content = $docData->delivery_doc) {
                $arr = explode(',', $content);
                $base64 = $arr[1];
                $arr2 = explode("/", $arr[0]);
                $typeA = explode(";", $arr2[1]);
                $file = str_replace("data:","",$arr2[0]);
                $type = $typeA[0];
                return response()->make(base64_decode($base64), 200, [
                    'Content-Type' => "$file/$type",
                    'Content-Disposition' => 'attachment; filename="Delivery_'.$id.".$type"
                ]);
            }
        }
    }

    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        $result = $procedureManager->execute('TICKET.SERVICE_EQUIPMENT_RECEIVE_CRUD', $request)->getParams();
        // dd($result);
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('admin.equipment-receive.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('admin.equipment-receive.index', ['id' => $id]);

         return redirect()->route('admin.equipment-receive.index');
    }

    public function equipmentDelivery($id = null, Request $request,ProcedureManager $procedureManager)
    {
       // dd($request->all());
        DB::beginTransaction();
        $result = EquipmentReceive::where('receipt_no',$request->get("receipt_no"))->update(['delivery_doc'=> $request->get("delivery_doc"), 'delivered_yn'=> 'Y']);

        if ($result == 1) {

//            $request->insert_by = Auth::id();
            $equipment = EquipmentReceive::find($request->get('receipt_no'));
            $request->merge([
                "equipment_status_id" => 1,
                "equipment_no" => $equipment->equipment_no
            ]);
             $procedureManager->execute('EQUIPMENT.EQUIPMENT_STATUS_CHANGE', $request)->getParams();
             DB::commit();

            Session::flash('success', 'DELIVERY STATUS UPDATED SUCCESSFULLY');
            return redirect()->to(url('/admin/equipment-receive-detail?id='.$request->get("receipt_no")));
        }
        DB::rollBack();

        Session::flash('error', 'DELIVERY STATUS UPDATED UNSUCCESSFUL');
        if ($id)
            return redirect()->route('admin.equipment-receive.detail', ['id' => $request->get("receipt_no")]);
    }
}
