<?php

namespace App\Http\Controllers\Ccms;

use App\Entities\Ccms\ServiceTicketAssign;
use App\Http\Controllers\Controller;
use App\Repositories\RequisitionMasterRepo;
use App\Repositories\ServiceTicketRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\Ccms\TicketType;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ServiceTicketManager;
use App\Managers\Ccms\ServiceTicketAssignManager;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceEngineerAssignTicketController extends Controller
{
    /**
     * @param Request $request
     * @param ServiceTicketManager $genSetupManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    /** @var RequisitionMasterRepo */
    protected $serviceTicketRepo;
    protected $requisitionMasterRepo;


    /**
     * ServiceTicketManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
    public function __construct(ServiceTicketRepo $serviceTicketRepo, RequisitionMasterRepo $requisitionMasterRepo)
    {
        $this->serviceTicketRepo = $serviceTicketRepo;
        $this->requisitionMasterRepo = $requisitionMasterRepo;
    }


    public function index()
    {
        return view('ccms.service_engineer.service_engineer_assign_ticket');
    }

    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param ServiceTicketManager $serviceTicketManager
     * @return mixed
     * @throws \Exception
     */

    public function list() {

        /*$sql = "SELECT
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
                     ASSIGNMENT_DATE,
                     ST.TICKET_NO,
                     ST.OCCURANCE_DATE,
                     EMP2.EMP_NAME,
                     EMP2.DESIGNATION_ID,
                     EMP2.DPT_DEPARTMENT_ID
                        FROM SERVICE_TICKET_ASSIGN STA
                         INNER JOIN  SERVICE_TICKET ST ON (STA.TICKET_NO = ST.TICKET_NO)
                         INNER JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = STA.SERVICE_ENGINEER_ID)
                         INNER JOIN PMIS.EMPLOYEE EMP2 ON (ST.EMP_ID = EMP2.EMP_ID)
                         LEFT JOIN  CPA_SECURITY.SEC_USERS U ON (U.USER_ID = STA.ASSIGN_BY)
                         LEFT JOIN PMIS.EMPLOYEE EMP ON (U.EMP_ID = EMP.EMP_ID)
                         WHERE SEI.USER_NAME = :user_name order by st.ticket_no desc";

        $data = DB::select($sql,['user_name' =>  auth()->user()->user_name]);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('assignment_date', function ($query) {
                return Carbon::parse($query->assignment_date)->format('d-m-Y');
            })
            ->addColumn('ticket_no', function ($query) {
                return '<a target="_blank" href="' .route('service_ticket.ticket_dtl', ['id' => $query->ticket_no, 'f' => 'se']). '" class="">'.$query->ticket_no.'</a>';
            })
            ->addColumn('OCCURANCE_DATE', function ($query) {
                return Carbon::parse($query->assignment_date)->format('d-m-Y');
            })
            ->addColumn('action', function ($query) {
                $optionHtml = '<a href="' .route('service_ticket.ticket_dtl', ['id' => $query->ticket_no, 'f' => 'se']). '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
                $optionHtml .= '<a title="Add action for the ticket" href="' .route('service-engineer-ticket.ticket-dtl', ['id' => $query->ticket_no]). '" class=""><i class="bx bxs-comment-add"></i></a>';
                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);*/

        $data = $this->serviceTicketRepo->getServiceTicketDashboard();
        //dd($data);
        return \Yajra\DataTables\DataTables::of($data->orderBy('ticket_no', 'desc')->get())
            ->addIndexColumn()
            ->addColumn('ticket_id', function ($data) {
                return '<a target="_blank" href="' .route('service_ticket.ticket_dtl', ['id' => $data->ticket_no, 'f' => 'se']). '" class="">'.$data->ticket_id.'</a>';
            })

            ->addColumn('equipment_name', function ($data) {
                $optionHtml = '<a target="_blank" href="' .route('admin.equipment-list.detail', ['id' => $data->equipment_no]). '" class="">'.$data->equipment_name.'</a>';

                return $optionHtml;
            })
            ->addColumn('assigned_to', function ($data) {
                $assigned_to = DB::selectOne('SELECT SEI.SERVICE_ENGINEER_NAME
        FROM SERVICE_TICKET_ASSIGN STA
         INNER JOIN  SERVICE_TICKET ST ON (STA.TICKET_NO = ST.TICKET_NO)
         INNER JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = STA.SERVICE_ENGINEER_ID)
         WHERE STA.TICKET_NO = :ticket_no', ['ticket_no' => $data->ticket_no]);
                if (!empty($assigned_to)) {
                    $html = <<<HTML
<span class="badge badge-success">&nbsp$assigned_to->service_engineer_name&nbsp</span>
HTML;
                    return $html;
                } else {
                    $html = <<<HTML
<span class="badge badge-danger">Unassigned</span>
HTML;
                    return $html;
                }
            })
            ->addColumn('emp_id', function ($data) {
                if ($data->ticket_for == '3') {
                    if ($data->department_id != null) {
                        $dept = DB::selectOne('select DEPARTMENT_NAME from PMIS.L_DEPARTMENT where DEPARTMENT_ID =:DEPARTMENT_ID', ['DEPARTMENT_ID' => $data->department_id]);
                        return $dept->department_name;
                    }
                } else {
                    if ($data->emp_id != null) {
                        $employee = DB::selectOne('select emp_name, emp_code from pmis.employee where emp_id =:emp_id', ['emp_id' => $data->emp_id]);
                        return $employee->emp_name . " (" . $employee->emp_code . ")";
                    }
                }

            })
            ->addColumn('ticket_priority', function ($data) {
                $priority = DB::selectOne('select REMARKS from L_SERVICE_TICKET_PRIORITY where TICKET_PRIORITY_NO =:TICKET_PRIORITY_NO', ['TICKET_PRIORITY_NO' => $data->ticket_priority_no]);
                //return $priority->remarks;
                if($priority){
                    if (strtoupper($priority->remarks) == 'HIGH') {
                        $html = <<<HTML
<span class="badge badge-danger">$priority->remarks</span>
HTML;
                        return $html;

                    } else if (strtoupper($priority->remarks) == 'MEDIUM') {
                        $html = <<<HTML
<span class="badge badge-warning">$priority->remarks</span>
HTML;
                        return $html;
                    } else if (strtoupper($priority->remarks) == 'NORMAL') {
                        $html = <<<HTML
<span class="badge badge-primary">$priority->remarks</span>
HTML;
                        return $html;
                    } else {
                        $html = <<<HTML
<span class="badge badge-light">$priority->remarks</span>
HTML;
                        return $html;
                    }
                }


            })
            ->addColumn('description', function ($data) {
                if(!empty($data->ticket_description)){
                    $pieces = explode(" ", $data->ticket_description);
                    $first_line = implode(" ", array_splice($pieces, 0, 12));
                    $show_line = $first_line.'....';
                }else{
                    $show_line = '';
                }
                return $show_line;
            })
            ->addColumn('ticket_type_no', function ($data) {
                $type = TicketType::where('ticket_type_no', $data->ticket_type_no)->first();
                if ($type)
                    return $type->ticket_type_name;
                return null;
            })
            ->addColumn('ticket_internal_external_yn', function ($data) {
                if ($data->ticket_internal_external_yn == 'Y') {
                    $optionHtml = '<span class="badge badge-success">Yes</span>';
                    return $optionHtml;
                } else {
                    $optionHtml = '<span class="badge badge-danger">&nbspNo&nbsp</span>';
                    return $optionHtml;
                }
            })
            ->addColumn('ticket_status', function ($data) {
                if ($data->service_status_no != null) {
                    $status = DB::selectOne('select STATUS_NAME from L_SERVICE_STATUS where STATUS_NO =:STATUS_NO', ['STATUS_NO' => $data->service_status_no]);
                    if (!empty($status)) {
                        if ($data->service_status_no == '1007') {
                            $html = <<<HTML
<span class="badge badge-primary">$status->status_name</span>
HTML;
                            return $html;

                        } else if ($data->service_status_no == '1008') {
                            $html = <<<HTML
<span class="badge badge-danger">$status->status_name</span>
HTML;
                            return $html;
                        } else if ($data->service_status_no == '1001') {
                            $html = <<<HTML
<span class="badge badge-warning">$status->status_name</span>
HTML;
                            return $html;
                        } else if ($data->service_status_no == '1003') {
                            $html = <<<HTML
<span class="badge badge-secondary">$status->status_name</span>
HTML;
                            return $html;
                        } else if ($data->service_status_no == '1004') {
                            $html = <<<HTML
<span class="badge badge-light">$status->status_name</span>
HTML;
                            return $html;
                        } else if ($data->service_status_no == '1006') {
                            $html = <<<HTML
<span class="badge badge-dark">$status->status_name</span>
HTML;
                            return $html;
                        } else {
                            $html = <<<HTML
<span class="badge badge-success">$status->status_name</span>
HTML;
                            return $html;
                        }
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }
            })
            /*->addColumn('action', function ($data) {
                //$optionHtml = '<a href="' . route('service_ticket.index', ['id' => $data->ticket_no]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                $optionHtml = '<a href="' . route('service_ticket.ticket_dtl', ['id' => $data->ticket_no]) . '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
//                $optionHtml .= '<a class="confirm-delete text-danger" href="' . $data->ticket_no . '"><i class="bx bx-trash cursor-pointer"></i></a>';
                return $optionHtml;
            })*/
            ->addColumn('action', function ($query) {
                $optionHtml = '<a href="' .route('service_ticket.ticket_dtl', ['id' => $query->ticket_no, 'f' => 'se']). '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
                $optionHtml .= '<a title="Add action for the ticket" href="' .route('service-engineer-ticket.ticket-dtl', ['id' => $query->ticket_no]). '" class=""><i class="bx bxs-comment-add"></i></a>';
                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
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
        $commentsData = DB::select("SELECT STA.TICKET_NO, STA.ACTION_NO, STA.ACTION_NOTE, STA.STATUS_NO, STA.INSERT_DATE, STA.TICKET_ACTION_ID, EMP.EMP_NAME FROM SERVICE_TICKET_ACTION STA, SERVICE_TICKET ST, PMIS.EMPLOYEE EMP
WHERE STA.TICKET_NO = '$ticket_no'
AND ST.EMP_ID = EMP.EMP_ID
AND ST.TICKET_NO = STA.TICKET_NO");
        //dd($commentsData);
        return view('ccms.service_engineer.ticket_dtl', compact('getTicketDetls', 'data', 'getServiceStatus', 'getTicketAction', 'getServiceEngineerId', 'getTicketNo', 'assigndata', 'gen_uniq_id', 'commentsData'));
    }

    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    { //dd($request);
        $result = $procedureManager->execute('TICKET.SERVICE_TICKET_ACTION_CRUD', $request)->getParams();

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->to(url('/service-engineer-ticket-detail?id='.$request->get('ticket_no')));
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('service_ticket.index', ['id' => $id]);

        return redirect()->route('service_ticket.index');
    }

}
