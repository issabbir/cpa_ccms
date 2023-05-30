<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Entities\Ccms\EquipmentList;
use App\Entities\Security\Role;
use App\Entities\Security\SecUserRoles;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAssigneManager;
use App\Managers\Ccms\EquipmentReceiveManager;
use App\Managers\Ccms\ThirdPartyServiceManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entities\Ccms\TicketType;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ServiceTicketManager;
use App\Managers\Ccms\ServiceTicketAssignManager;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    /**
     * @param Request $request
     * @param ServiceTicketManager $genSetupManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, ThirdPartyServiceManager $thirdPartyServiceManager, EquipmentAssigneManager $equipmentAssigneManager, ServiceTicketManager $serviceTicketManager, ServiceTicketAssignManager $serviceTicketAssignManager)
    {
        $data = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
        $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        $getTicketPriorityNo = $serviceTicketManager->getServiceTicketRepo()->findAllTicketPriority();
        $getTicketTypeNo = $serviceTicketManager->getServiceTicketRepo()->findAllTicketType();
        $assigndata = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findOne($request->get('id'));
        $getTicketNo =  $serviceTicketAssignManager->getServiceTicketAssignRepo()->getTicketNo();
        $getServiceEngineerId = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findAllServiceEngineer();
        $getServiceStatus = $serviceTicketManager->getServiceTicketRepo()->findServiceStatus();
        $sections = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllSection();
        if(Auth::user()->hasRole('CCMS_ADMIN')||Auth::user()->hasRole('CCMS_TICKET_MANAGER')){
            $ticketFor = DB::select("SELECT '1' AS ticket_for_id, 'MYSELF' AS ticket_for FROM DUAL
      UNION ALL
      SELECT '2' AS ticket_for_id, 'OTHERS' AS ticket_for FROM DUAL
      UNION ALL
      SELECT '3' AS ticket_for_id, 'DEPARTMENT' AS ticket_for FROM DUAL");
        }else{
            $ticketFor = DB::select("SELECT '1' AS ticket_for_id, 'MYSELF' AS ticket_for FROM DUAL");
        }

        $departments = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllDepartment();
//        $getEquipmentID =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
        $getEquipmentID = DB::select ("select * from EQUIPMENT_LIST EL
                LEFT JOIN EQUIPMENT_ASSIGN EA ON (EA.EQUIPMENT_NO = EL.EQUIPMENT_NO)
                where EA.emp_id= :emp_id and EL.EQUIPMENT_STATUS_ID = 1", ['emp_id' => Auth::user()->emp_id]);
        $myTicket = 'N';
        return view('ccms.admin.manage_tickets.service_ticket', compact('data', 'gen_uniq_id', 'getTicketPriorityNo',
            'getTicketTypeNo', 'getServiceEngineerId', 'getTicketNo', 'assigndata', 'myTicket', 'ticketFor', 'departments', 'getEquipmentID',
            'getServiceStatus', 'sections'));
    }

    public function ticketDtl(Request $request, ServiceTicketManager $serviceTicketManager, EquipmentReceiveManager $equipmentReceiveManager, ServiceTicketAssignManager $serviceTicketAssignManager, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $data = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
        $eqReceivedata = $equipmentReceiveManager->getEquipmentReceiveRepo()->findOne($request->get('id'));
        $getEquipmentNo = $equipmentReceiveManager->getEquipmentReceiveRepo()->findAllEquipmentList();
        $getTicketDetls = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
        $thardPartyData = $thirdPartyServiceManager->getThirdPartyServiceRepo()->findOne($request->get('id'));
        $getEquipmentID =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
        $ticketNumber =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getTicketNo();
        $getVendorNo =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getVendorNo();
        $priority = DB::selectOne('select REMARKS from L_SERVICE_TICKET_PRIORITY where TICKET_PRIORITY_NO =:TICKET_PRIORITY_NO', ['TICKET_PRIORITY_NO' => $getTicketDetls->ticket_priority_no]);
        if(!empty($priority)){
            $getTicketDetls->ticket_priority = $priority->remarks;
        }
        $ticket_type = DB::selectOne('select TICKET_TYPE_NAME from L_SERVICE_TICKET_TYPE where TICKET_TYPE_NO =:TICKET_TYPE_NO', ['TICKET_TYPE_NO' => $getTicketDetls->ticket_type_no]);
        if(!empty($ticket_type)){
            $getTicketDetls->ticket_type = $ticket_type->ticket_type_name;
        }
        $equipment_name = DB::selectOne('select EQUIPMENT_NAME from EQUIPMENT_LIST where EQUIPMENT_NO =:EQUIPMENT_NO', ['EQUIPMENT_NO' => $getTicketDetls->equipment_no]);
        if(!empty($equipment_name)){
            $getTicketDetls->equipment_name = $equipment_name->equipment_name;
        }
        $vendor_name = DB::selectOne('select vl.vendor_name, vl.vendor_no from vendor_list vl
left join equipment_list el on (el.vendor_no = vl.vendor_no)
where el.equipment_no = :equipment_no', ['equipment_no' => $getTicketDetls->equipment_no]);
        if(!empty($vendor_name)){
            $getTicketDetls->vendor_name = $vendor_name->vendor_name;
            $getTicketDetls->vendor_no = $vendor_name->vendor_no;
        }
        $getTicketAction = $serviceTicketManager->getServiceTicketRepo()->serviceTicketAction();
        $getServiceStatus = $serviceTicketManager->getServiceTicketRepo()->findServiceStatus();
        $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        $assigndata = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findOne($request->get('id'));
        $getTicketNo =  $serviceTicketAssignManager->getServiceTicketAssignRepo()->getTicketNo();
        $getServiceEngineerId = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findAllServiceEngineer();
        $getData = $serviceTicketManager->getServiceTicketRepo()->getData($request->get('id'));
        $countTpsNo = DB::selectOne("SELECT count(*) as count_data from third_party_service TPS, service_ticket ST
where TPS.ticket_no = ST.ticket_no
and TPS.ticket_no =:ticket_no", ['ticket_no' => $getData->ticket_no]);
        $countEqpNo = DB::selectOne("SELECT count(*) as count_data from SERVICE_EQUIPMENT_RECEIVE SER, EQUIPMENT_LIST EL
where SER.EQUIPMENT_NO = EL.EQUIPMENT_NO
and SER.DELIVERED_YN <> 'Y'
and SER.EQUIPMENT_NO =:equipment_no", ['equipment_no' => $getData->equipment_no]);
//        $countEqpNo = DB::select("SELECT * from SERVICE_EQUIPMENT_RECEIVE
//where DELIVERED_YN <> 'Y'
//and EQUIPMENT_NO =:equipment_no
//and TICKET_NO = :ticket_no", ['equipment_no' => $getData->equipment_no,'ticket_no' => $getData->ticket_no]);
//        dd($getTicketDetls);
        $ticket_no = $request->get('id');
        $commentsData = DB::select("SELECT STA.TICKET_NO,
            STA.ACTION_NO,
            STA.ACTION_NOTE,
            STA.STATUS_NO,
            STA.INSERT_DATE,
            STA.TICKET_ACTION_ID,
            CASE WHEN EMP.EMP_NAME IS NOT NULL THEN EMP.EMP_NAME ELSE 'SE -'||SEI.SERVICE_ENGINEER_NAME END CREATED_BY,
            STAL.ACTION_DESCRIPTION as ACTION_TAKEN,
            SS.STATUS_NAME as STATUS,
            eiv.DESIGNATION,
            eiv.DEPARTMENT_NAME,
            eiv.CONTRACT
        FROM ccms.SERVICE_TICKET_ACTION STA
        INNER JOIN ccms.SERVICE_TICKET ST on (ST.TICKET_NO = STA.TICKET_NO)
        LEFT JOIN ccms.L_SERVICE_TICKET_ACTION_LIST STAL ON (STA.ACTION_NO = STAL.ACTION_NO)
        LEFT JOIN ccms.L_SERVICE_STATUS SS ON (STA.STATUS_NO = SS.STATUS_NO)
        LEFT JOIN  CPA_SECURITY.SEC_USERS U ON (U.USER_ID = STA.INSERT_BY)
        LEFT JOIN PMIS.EMPLOYEE EMP ON (U.EMP_ID = EMP.EMP_ID)
        LEFT JOIN pmis.EMPLOYEE_INFO_VU eiv ON (emp.emp_id = eiv.emp_id)
        LEFT JOIN ccms.SERVICE_ENGINEER_INFO  SEI ON (SEI.USER_NAME = U.USER_NAME)
        WHERE STA.TICKET_NO = :ticket_no
        ORDER BY STA.INSERT_DATE DESC
", ['ticket_no' => $ticket_no]);
        $countTicketNo = DB::selectOne("SELECT count(*) as count_data from SERVICE_TICKET_ASSIGN STA, SERVICE_TICKET ST
where STA.TICKET_NO = ST.TICKET_NO
and STA.TICKET_NO =:ticket_no", ['ticket_no' => $ticket_no]);
        $assignedTo = DB::selectOne("SELECT
                             SEI.SERVICE_ENGINEER_NAME,
                             SEI.SERVICE_ENGINEER_NAME,
                             SEI.SERVICE_ENGINEER_ID,
                             SEI.SERVICE_ENGINEER_INFO_ID,
                             STA.ASSIGNMENT_NO,
                             STA.ASSIGNMENT_ID,
                             U.USER_NAME ASSIGNED_BY_USERNAME,
                             EMP.EMP_NAME ASSIGNED_BY_EMP_NAME,
                             EMP.EMP_ID ASSIGNED_BY_EMP_ID,
                             ASSIGNMENT_NOTE,
                             ASSIGNMENT_DATE
                                FROM SERVICE_TICKET_ASSIGN STA
                                 INNER JOIN  SERVICE_TICKET ST ON (STA.TICKET_NO = ST.TICKET_NO)
                                 INNER JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = STA.SERVICE_ENGINEER_ID)
                                 LEFT JOIN  CPA_SECURITY.SEC_USERS U ON (U.USER_ID = STA.ASSIGN_BY)
                                 LEFT JOIN PMIS.EMPLOYEE EMP ON (U.EMP_ID = EMP.EMP_ID)
                                 WHERE STA.TICKET_NO = :ticket_no
                                 order by sta.INSERT_DATE  desc
                                 ", ['ticket_no' => $ticket_no]);

        $requisitionData = DB::select("select erm.requisition_id,rs.status_name,erm.ticket_yn,erm.ticket_no,erm.equipment_no,erm.requisition_note,erm.requisition_date,emp.emp_name as requisition_for, erm.requisition_mst_no
from equipment_requisition_mst erm, service_ticket st, pmis.employee emp, l_requisition_status rs
where erm.ticket_no = :ticket_no
and erm.ticket_no = st.ticket_no
and erm.requisition_status_id = rs.requisition_status_id
and erm.requisition_for = emp.emp_id", ['ticket_no' => $ticket_no]);
        $thirdPartyData = DB::select("select tps.*, vl.vendor_name, el.equipment_name from third_party_service tps, service_ticket st, vendor_list vl, equipment_list el
where tps.ticket_no = :ticket_no
and tps.ticket_no = st.ticket_no
and tps.vendor_no = vl.vendor_no
and tps.equipment_no = el.equipment_no", ['ticket_no' => $ticket_no]);

        return view('ccms.admin.manage_tickets.ticket_dtl', compact('getTicketDetls', 'data', 'getServiceStatus',
            'getTicketAction', 'getServiceEngineerId', 'getTicketNo', 'assigndata', 'gen_uniq_id', 'commentsData', 'countTicketNo',
            'assignedTo','requisitionData','thirdPartyData', 'eqReceivedata', 'getEquipmentNo', 'getData', 'countEqpNo', 'thardPartyData',
            'getEquipmentID', 'ticketNumber', 'getVendorNo', 'countTpsNo'));
    }

    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param ServiceTicketManager $serviceTicketManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, ServiceTicketManager $serviceTicketManager) {
        return $serviceTicketManager->getServiceTicketTables($request);
    }

    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        if($request->get('ticket_type_no')=='1004'){
            $request->merge([
                "meeting_start_time" => $request->get('occurance_date'). " ".$request->get('meeting_start_time'),
                "meeting_end_time" => $request->get('occurance_date'). " ".$request->get('meeting_end_time')
            ]);
        }
        if($request->get('ticket_for')=='1'){
            $request->request->add(['emp_id' => auth()->user()->emp_id]);
        }
        $getKey = json_encode(Auth::user()->roles->pluck('role_key'));
        if(strpos($getKey, "CCMS_GENERAL_USER") !== FALSE) {
            $request->request->add(['ticket_priority_no' => 2012093419]);
        }
//        dd($request);
        $result = $procedureManager->execute('TICKET.SERVICE_TICKET_CRUD', $request)->getParams();

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('service_ticket.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('service_ticket.index', ['id' => $id]);

        return redirect()->route('service_ticket.index');
    }

    public function storeTicketComments($id = null, Request $request, ProcedureManager $procedureManager)
    {
       // dd($request->all());
        $result = $procedureManager->execute('TICKET.SERVICE_TICKET_ACTION_CRUD', $request)->getParams();

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->to(url('/admin/service-ticket-detail?id='.$request->get('ticket_no')));
        }
        Session::flash('error', $result['o_status_message']);
        return redirect()->to(url('/admin/service-ticket-detail?id='.$request->get('ticket_no')));
    }

    public function storeTicketAssign($id = null, Request $request, ProcedureManager $procedureManager,ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $result = $procedureManager->execute('TICKET.SERVICE_TICKET_ASSIGN_CRUD', $request)->getParams();
        if ($result['o_status_code'] == 1) {
            $notification_to=$thirdPartyServiceManager->getEmployeeUserInfoByEmpId($request->get('user_name'));
            $url='admin/service-ticket-detail?id='.$result['p_ticket_no'].'&f=se';
            $note='A service issue assigned to you';
            $thirdPartyServiceManager->sendToNotification($notification_to->user_id,$note,41,$url);
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('service_ticket.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('ticket_assign.index', ['id' => $id]);

        return redirect()->route('service_ticket.index');
    }

    public function storeEqReceive($id = null, Request $request, ProcedureManager $procedureManager)
    {
     // dd($request->all());
        $result = $procedureManager->execute('TICKET.SERVICE_EQUIPMENT_RECEIVE_CRUD', $request)->getParams();
        // dd($result);
        if ($result['o_status_code'] == 1) {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'p_ticket_no' => $request->get('ticket_no'),
                'p_action_no' => 1002,
                'p_action_note' => 'Equipment has been received',
                'p_status_no' => 21122013486,
                'p_insert_by' => Auth::id(),
                'p_insert_date' => date('Y-m-d H:i:s'),
                'p_update_by' => Auth::id(),
                'p_update_date' => date('Y-m-d H:i:s'),
                'p_ticket_action_id' => null,
                'p_emp_id' => auth()->user()->emp_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            DB::executeProcedure('TICKET.SERVICE_TICKET_ACTION_CRUD', $params);
            //dd($params);
            Session::flash('success', $result['o_status_message']);
            return redirect()->to(url('/admin/service-ticket-detail?id='.$request->get('ticket_no')));
        }
        Session::flash('error', $result['o_status_message']);
        return redirect()->to(url('/admin/service-ticket-detail?id='.$request->get('ticket_no')));
    }


    public function storeThirdParty($id = null, Request $request, ProcedureManager $procedureManager,ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        //dd($request);
        $result = $procedureManager->execute('TICKET.THIRD_PARTY_SERVICE_CRUD', $request)->getParams();
         //dd($result);
        if ($result['o_status_code'] == 1) {
            $url='admin/third-party-service-detail-view?id='.$result['third_party_service_id']['value'].'&f=se';
//            $note='Need to forward to system analyst for third party service.';
//            HelperClass::sendNotification('CCMS_ADMIN',$note,$url);
            $note='Need to approved for third party service.';
            HelperClass::sendNotification('CCMS_SYSTEM_ANALYST',$note,$url);
            Session::flash('success', $result['o_status_message']);
            return redirect()->to(url('/admin/service-ticket-detail?id='.$request->get('ticket_no')));
        }
        Session::flash('error', $result['o_status_message']);
        return redirect()->to(url('/admin/service-ticket-detail?id='.$request->get('ticket_no')));
    }

    public function removeServiceTicket(Request $request)
    {
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'P_TICKET_NO' => $request->get('ticket_no'),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        DB::executeProcedure('TICKET.SERVICE_TICKET_DELETE', $params);
        return $params['o_status_code'];
    }

    public function ticketTypeDtl(Request $request)
    {
        $typeKey = DB::selectOne("select TYPE_KEY from L_SERVICE_TICKET_TYPE
where TICKET_TYPE_NO = :TICKET_TYPE_NO", ['TICKET_TYPE_NO' => $request->get('ticket_type_no')]);
        return $typeKey->type_key;
    }

    function getEquipmentList(Request $request)
    {
        $emp_id = $request->input('emp_id');
        $dept_id = $request->input('dept_id');

        if(!empty($emp_id)){
            $equipmentList = DB::select ("select * from EQUIPMENT_LIST EL
LEFT JOIN EQUIPMENT_ASSIGN EA ON (EA.EQUIPMENT_NO = EL.EQUIPMENT_NO)
where EA.emp_id= :emp_id", ['emp_id' => $emp_id]);
        }else if(!empty($dept_id)){
            $equipmentList = DB::select ("select * from EQUIPMENT_LIST EL
LEFT JOIN EQUIPMENT_ASSIGN EA ON (EA.EQUIPMENT_NO = EL.EQUIPMENT_NO)
where EA.DEPARTMENT_ID= :DEPARTMENT_ID", ['DEPARTMENT_ID' => $dept_id]);
        }


        $msg = '<option value="">-- Please select an option --</option>';
        foreach ($equipmentList as $data){
            $msg .= '<option value="'.$data->equipment_no.'">'.$data->equipment_name.'</option>';
        }
        return $msg;
    }

}
