<?php
/**
 * Created by PhpStorm.
 * User: ashraf
 * Date: 2/11/20
 * Time: 11:14 AM
 */

namespace App\Http\Controllers;

use App\Entities\Ccms\EngineerTicketStatus;
use App\Entities\Ccms\ThirdPartyService;
use App\Entities\Ccms\TicketIssueStatus;
use App\Entities\Ccms\TicketType;
use App\Http\Controllers\Controller;

use App\Managers\Ccms\RequisitionMasterManager;
use App\Managers\Ccms\ThirdPartyServiceManager;
use App\Repositories\RequisitionMasterRepo;
use App\Repositories\ServiceTicketRepo;
use App\Repositories\ThirdPartyServiceRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    /** @var RequisitionMasterRepo */
    protected $serviceTicketRepo;
    protected $requisitionMasterRepo;
    protected $thirdPartyServiceRepo;

    /**
     * ServiceTicketManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
    public function __construct(ServiceTicketRepo $serviceTicketRepo, RequisitionMasterRepo $requisitionMasterRepo,ThirdPartyServiceRepo $thirdPartyServiceRepo)
    {
        $this->serviceTicketRepo = $serviceTicketRepo;
        $this->requisitionMasterRepo = $requisitionMasterRepo;
        $this->thirdPartyServiceRepo = $thirdPartyServiceRepo;
    }


    public function index(Request $request)
  {
//dd(auth()->user()->user_id);
        //$ticketStatus = TicketIssueStatus::all();
        $enginTicketStatus = EngineerTicketStatus::all();
        return view('dashboard.index', compact( 'enginTicketStatus'));
    }

    public function ticketIssueStatuslist()
    {
        $data = TicketIssueStatus::all();
//        dd($data);
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('total_assigned_issues', function ($ticket) {
                return '<a target="_blank" href="' . route('service_ticket.index') .'?ticket_type_no='.$ticket->ticket_type_no. '" class="badge">'.$ticket->total_assigned_issues.'</a>';
            })
            ->addColumn('total_resolved_issues', function ($ticket) {
                return '<a target="_blank" href="' . route('service_ticket.index') .'?ticket_type_no='.$ticket->ticket_type_no . '&' . 'service_status_no='.'1005'. '" class="badge">'.$ticket->total_resolved_issues.'</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function ticketList()
    {
        $data = $this->serviceTicketRepo->getServiceTicketDashboard();
//        dd($data);
        return Datatables::of($data->orderBy('ticket_no', 'desc')->get())
            ->addIndexColumn()
            ->addColumn('ticket_id', function ($data) {
                return '<a target="_blank" href="' .route('service_ticket.ticket_dtl', ['id' => $data->ticket_no, 'f' => 'se']). '" class="">'.$data->ticket_id.'</a>';
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
            ->addColumn('action', function ($data) {
                //$optionHtml = '<a href="' . route('service_ticket.index', ['id' => $data->ticket_no]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                $optionHtml = '<a href="' . route('service_ticket.ticket_dtl', ['id' => $data->ticket_no]) . '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
//                $optionHtml .= '<a class="confirm-delete text-danger" href="' . $data->ticket_no . '"><i class="bx bx-trash cursor-pointer"></i></a>';
                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function reqlist()
    {
        $requisition = $this->requisitionMasterRepo->getRequisitionMasterDashboard();
//        dd($requisition);
        return datatables()->of($requisition)
           ->addIndexColumn()
           ->addColumn('requisition_id', function ($requisition) {
               return '<a target="_blank" href="' . route('admin.requisition-master.detail-view',
                       ['id' => $requisition->requisition_mst_no]) . '" class="">'.$requisition->requisition_id.'</a>';
           })
            ->addColumn('equipment_name', function ($requisition) {
                $optionHtml = '<a href="' .route('admin.equipment-list.detail', ['id' => $requisition->equipment_no]). '"
class="" target="_blank"><span>'.$requisition->equipment_name.'</span></a>';
                return $optionHtml;
            })
           ->escapeColumns([])
           ->make(true);
    }
    public function serviceList(Request $request, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $data = ThirdPartyService::where('approved_yn','!=','Y')->orderBy('insert_date','desc')->get();
        if ($request->get('filter_data') && $equipment_no = $request->get('filter_data')["equipment_no_filter"]){
            $data = $data->where('equipment_no',$equipment_no);
        }

        if ($request->get('filter_data') && $vendor_no = $request->get('filter_data')["vendor_no_filter"]){
            $data = $data->where('vendor_no',$vendor_no);
        }

        if ($request->get('filter_data') && isset($request->get('filter_data')["problem_solved_yn_filter"]) && $problem_solved_yn = $request->get('filter_data')["problem_solved_yn_filter"]) {
            $data = $data->where('problem_solved_yn', $problem_solved_yn);
        }

        if ($request->get('filter_data') && $send_date = $request->get('filter_data')['send_date']) {
            $send_date = date('Y-m-d 00:00:00', strtotime($send_date));
            $data = $data->where('sending_date' ,'>=', $send_date);
        }

        if ($request->get('filter_data') && $receive_date = $request->get('filter_data')['receive_date']) {
            $receive_date = date('Y-m-d 23:59:59', strtotime($receive_date));
            $data = $data->where('received_date' ,'<=', $receive_date);
        }
        // dd($data);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sending_date', function ($query) {
                return Carbon::parse($query->sending_date)->format('d-m-Y');
            })
            ->addColumn('received_date', function ($query) {
                return Carbon::parse($query->received_date)->format('d-m-Y');
            })
            ->addColumn('problem_description', function ($data) {
                if(!empty($data->problem_description)){
                    $pieces = explode(" ", $data->problem_description);
                    $first_line = implode(" ", array_splice($pieces, 0, 12));
                    $show_line = $first_line.'....';
                }else{
                    $show_line = '';
                }
                return $show_line;
            })
            /*->addColumn('problem_solved_yn', function ($data) {
                if ($data->problem_solved_yn == 'Y') {
                    $optionHtml = '<span class="badge badge-success">RESOLVED</span>';
                    return $optionHtml;
                } else {
                    $optionHtml = '<span class="badge badge-danger">NOT RESOLVED</span>';
                    return $optionHtml;
                }
            })*/
            ->addColumn('equipment_no', function ($data) {
                $equipment = DB::selectOne('select EQUIPMENT_NAME from EQUIPMENT_LIST where EQUIPMENT_NO = :EQUIPMENT_NO', ['EQUIPMENT_NO' => $data->equipment_no]);
                if (!empty($equipment)) {
                    return $equipment->equipment_name;
                } else {
                    return '';
                }
            })
            ->addColumn('vendor_no', function ($data) {
                $vendor = DB::selectOne('select VENDOR_NAME from VENDOR_LIST where VENDOR_NO = :VENDOR_NO', ['VENDOR_NO' => $data->vendor_no]);
                if (!empty($vendor)) {
                    return $vendor->vendor_name;
                } else {
                    return '';
                }
            })
            ->addColumn('action', function ($data) {
                //$optionHtml = '<a href="'.route('admin.third_party.index', ['id' => $data['third_party_service_id']]).'" class="" title="Edit Third Party"><i class="bx bx-edit cursor-pointer"></i></a>';
                $optionHtml = '<a href="' .route('admin.third_party.detail-view', ['id' => $data['third_party_service_id']]). '" class=""><i class="bx bx-show cursor-pointer"></i></a> &nbsp;';
                if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST')  && $data->approved_yn != 'Y'){
                    $optionHtml .= '<a  href="' .route('admin.third_party.approve-modal', ['id' => $data['third_party_service_id']]). '" class="show-third-party-modal" title="Approve"><i class="bx bx-calendar-check  cursor-pointer text-warning"></i></a>';
                }elseif (!auth()->user()->hasRole('CCMS_SYSTEM_ANALYST')  && $data->approved_yn != 'Y'){
                    $optionHtml .=  '<i title="Not Approve" class="bx bx-calendar-check text-danger"></i>';
                }else{
                    $optionHtml .= '<i title="Approved" class="bx bx-calendar-check text-success"></i>';
                }
//                else if($data->forward_yn != 'Y' && $data->approved_yn != 'Y' && auth()->user()->hasRole('CCMS_ADMIN')){
//                    $optionHtml .= '<a href="' .route('admin.third_party.forward', ['id' => $data['third_party_service_id']]). '" class="" title="Forward to Analyst"><i class="bx bx-calendar-check  cursor-pointer text-warning"></i></a>';
//                }
//                else if($data->forward_yn == 'Y' && $data->approved_yn != 'Y' && !auth()->user()->hasRole('CCMS_SYSTEM_ANALYST')){
//                    $optionHtml .=  '<i title="Forwarded" class="bx bx-calendar-check text-primary"></i>';
//                }
//               else if($data->forward_yn != 'Y' && $data->approved_yn != 'Y' ){
//                    $optionHtml .=  '<i title="Not Forward" class="bx bx-calendar-check text-danger"></i>';
//                }

                //$optionHtml .= '<a class="confirm-delete text-danger" href="'.$data['third_party_service_id'].'"><i class="bx bx-trash cursor-pointer"></i></a>';
                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
    }

//    public function ticketIssueStatuslist()
//    {
//        $ticketStatus = TicketIssueStatus::all();
//        return datatables()->of($ticketStatus)->addIndexColumn()->make(true);
//    }

    public function engTicketStatuslist()
    {
        $ticketStatus = EngineerTicketStatus::all();
        return datatables()->of($ticketStatus)->addIndexColumn()->make(true);
    }

}
