<?php

namespace App\Http\Controllers\Ccms;

use App\Entities\Ccms\ServiceTicket;
use App\Entities\Ccms\ServiceTicketAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Entities\Ccms\TicketType;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ServiceTicketManager;
use App\Managers\Ccms\ServiceTicketAssignManager;
use Illuminate\Http\Request;

class MyTicketController extends Controller
{
    	/**
    	 * @param Request $request
    	 * @param ServiceTicketManager $genSetupManager
    	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
    	 */
        public function index(Request $request, ServiceTicketManager $serviceTicketManager, ServiceTicketAssignManager $serviceTicketAssignManager)
        {
        	$data = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
            $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
            $getTicketPriorityNo = $serviceTicketManager->getServiceTicketRepo()->findAllTicketPriority();
            $getTicketTypeNo = $serviceTicketManager->getServiceTicketRepo()->findAllTicketType();
            $assigndata = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findOne($request->get('id'));
            $getTicketNo =  $serviceTicketAssignManager->getServiceTicketAssignRepo()->getTicketNo();
            $getServiceEngineerId = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findAllServiceEngineer();
            $userId = auth()->user()->emp_id;
            $myTicket = 'Y';
            // dd($ticketNo);
            return view('ccms.my_ticket.my_ticket', compact('data', 'gen_uniq_id', 'getTicketPriorityNo', 'getTicketTypeNo', 'getServiceEngineerId', 'getTicketNo', 'assigndata', 'userId','myTicket'));
        }

        public function ticketDtl(Request $request, ServiceTicketManager $serviceTicketManager, ServiceTicketAssignManager $serviceTicketAssignManager)
        {
            $data = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
            $getTicketDetls = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
            $getTicketAction = $serviceTicketManager->getServiceTicketRepo()->serviceTicketAction();
            $getServiceStatus = $serviceTicketManager->getServiceTicketRepo()->findServiceStatus();
            $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
            $assigndata = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findOne($request->get('id'));
            $getTicketNo =  $serviceTicketAssignManager->getServiceTicketAssignRepo()->getTicketNo();
            $getServiceEngineerId = $serviceTicketAssignManager->getServiceTicketAssignRepo()->findAllServiceEngineer();
            $ticket_no = $request->get('id');
            $commentsData = DB::select("SELECT
            STA.TICKET_NO,
            STA.ACTION_NO,
            STA.ACTION_NOTE,
            STA.STATUS_NO,
            STA.INSERT_DATE,
            STA.TICKET_ACTION_ID,
            CASE WHEN EMP.EMP_NAME IS NOT NULL THEN EMP.EMP_NAME ELSE 'SE -'||SEI.SERVICE_ENGINEER_NAME END CREATED_BY,
            STAL.ACTION_DESCRIPTION as ACTION_TAKEN,
            ST.STATUS_NAME as STATUS
        FROM SERVICE_TICKET_ACTION STA
        INNER JOIN SERVICE_TICKET ST on (ST.TICKET_NO = STA.TICKET_NO)
        LEFT JOIN L_SERVICE_TICKET_ACTION_LIST STAL ON (STA.ACTION_NO = STAL.ACTION_NO)
        LEFT JOIN L_SERVICE_STATUS ST ON (STA.STATUS_NO = ST.STATUS_NO)
        LEFT JOIN  CPA_SECURITY.SEC_USERS U ON (U.USER_ID = STA.INSERT_BY)
        LEFT JOIN PMIS.EMPLOYEE EMP ON (U.EMP_ID = EMP.EMP_ID)
        LEFT JOIN SERVICE_ENGINEER_INFO  SEI ON (SEI.USER_NAME = U.USER_NAME)
        WHERE STA.TICKET_NO = :ticket_no
", ['ticket_no' => $ticket_no]);
            //dd($commentsData);
            return view('ccms.my_ticket.my_ticket_dtl', compact('getTicketDetls', 'data', 'getServiceStatus', 'getTicketAction', 'getServiceEngineerId', 'getTicketNo', 'assigndata', 'gen_uniq_id', 'commentsData'));
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
            return $serviceTicketManager->getMyServiceTicketTables($request);
        }

        public function store($id = null, Request $request, ProcedureManager $procedureManager)
        {
            $request->merge([
                "meeting_start_time" => $request->get('occurance_date'). " ".$request->get('meeting_start_time'),
                "meeting_end_time" => $request->get('occurance_date'). " ".$request->get('meeting_end_time')
            ]);//dd($request);

            $result = $procedureManager->execute('TICKET.SERVICE_TICKET_CRUD', $request)->getParams();

            if ($result['o_status_code'] == 1) {
                Session::flash('success', $result['o_status_message']);
                return redirect()->route('my_ticket.index');
            }

            Session::flash('error', $result['o_status_message']);
            if ($id)
             return redirect()->route('my_ticket.index', ['id' => $id]);

             return redirect()->route('my_ticket.index');
        }

}
