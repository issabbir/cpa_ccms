<?php


namespace App\Managers\Ccms;


use App\Entities\Ccms\ServiceTicket;
use App\Entities\Ccms\TicketType;
use App\Repositories\ServiceTicketRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceTicketManager
{
    /** @var RequisitionMasterRepo */
    protected $serviceTicketRepo;


    /**
     * ServiceTicketManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
    public function __construct(ServiceTicketRepo $serviceTicketRepo)
    {
        $this->serviceTicketRepo = $serviceTicketRepo;
    }

    /**
     * Get Service Ticket Tables based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getMyServiceTicketTables(Request $request)
    {
        $data = $this->serviceTicketRepo->findMyTicket();
        //dd($data);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('occurance_date', function ($query) {
                return Carbon::parse($query->occurance_date)->format('d-m-Y');
            })
            ->addColumn('meeting_start_time', function ($query) {
                return Carbon::parse($query->meeting_start_time)->format('h:i A');
            })
            ->addColumn('meeting_end_time', function ($query) {
                return Carbon::parse($query->meeting_end_time)->format('h:i A');
            })
            ->addColumn('ticket_internal_external_yn', function ($data) {
                if ($data->ticket_internal_external_yn == 'Y') {
                    return 'Yes';
                } else {
                    return 'No';
                }
            })
            ->editColumn('insert_date', function ($data) {
                // dd($data);

                return date('d-m-Y h:i A', strtotime($data['created_at']));
            })
            ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('my_ticket.index', ['id' => $data['ticket_no']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                $optionHtml .= '<a href="' . route('my_ticket.ticket_dtl', ['id' => $data['ticket_no']]) . '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
                $optionHtml .= '<a class="confirm-delete text-danger" href=""><i class="bx bx-trash cursor-pointer"></i></a>';


                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function getServiceTicketTables(Request $request)
    {
        $data = $this->serviceTicketRepo->getServiceTicket();
//        $data = DB::select(DB::raw("  SELECT S.*, A.ASSIGNMENT_DATE
//    FROM SERVICE_TICKET S
//         LEFT JOIN SERVICE_TICKET_ASSIGN A ON S.TICKET_NO = A.TICKET_NO
//ORDER BY A.TICKET_NO DESC"));
//        dd($data);

        if ($request->get('filter_data') && isset($request->get('filter_data')["assigned_to"]) && $assigned_to = $request->get('filter_data')["assigned_to"]) {
            if (is_numeric($assigned_to)) {
                $data = $data->where('ASSIGN_ENGINEER_ID', $assigned_to);
            } else if (strtolower($assigned_to) == 'assigned') {
                $data = $data->whereNotNull('ASSIGN_ENGINEER_ID');
            } else {
                $data = $data->whereNull('ASSIGN_ENGINEER_ID');
            }
        }

        if ($request->get('filter_data') && $status_no = $request->get('filter_data')["status_no"]) {
            $data = $data->where('service_status_no', $status_no);
        }

        if ($request->get('filter_data') && $occurance_from_date = $request->get('filter_data')['occurance_from_date']) {
            $occurance_from_date = date('Y-m-d 00:00:00', strtotime($occurance_from_date));
            $data = $data->where('occurance_date', '>=', $occurance_from_date);
        }

        if ($request->get('filter_data') && $occurance_to_date = $request->get('filter_data')['occurance_to_date']) {
            $occurance_to_date = date('Y-m-d 23:59:59', strtotime($occurance_to_date));
            $data = $data->where('occurance_date', '<=', $occurance_to_date);
        }

        if ($request->get('filter_data') && $ticket_for = $request->get('filter_data')["ticket_for"]) {
            $data = $data->where('ticket_for', $ticket_for);
        }

        if ($request->get('filter_data') && $department_id = $request->get('filter_data')["department_id"]) {
            $data = $data->where('department_id', $department_id);
        }

        if ($request->get('filter_data') && $section_id = $request->get('filter_data')["section_id"]) {
            $data = $data->where('section_id', $section_id);
        }

        if ($request->get('filter_data') && $meeting_room_no = $request->get('filter_data')["meeting_room_no"]) {
            $data = $data->where('meeting_room_no', $meeting_room_no);
        }

        if ($request->get('filter_data') && isset($request->get('filter_data')["emp_id"]) && $emp_id = $request->get('filter_data')["emp_id"]) {
            $data = $data->where('emp_id', $emp_id);
        }

        $getTType = $request->get('ticket_type_no');
        if(isset($getTType)){
            $data = $data->where('ticket_type_no', $getTType);
        }else if ($request->get('filter_data') && $ticket_type_no = $request->get('filter_data')["ticket_type_no"]){
            $data = $data->where('ticket_type_no', $ticket_type_no);
        }

        $getSStatus = $request->get('service_status_no');
//        dd($getSStatus);
        if(isset($getSStatus)){
            $data = $data->where('service_status_no', $getSStatus);
        }else if ($request->get('filter_data') && $ticket_type_no = $request->get('filter_data')["ticket_type_no"]){
            $data = $data->where('ticket_type_no', $ticket_type_no);
        }

        if ($request->get('filter_data') && $ticket_priority_no = $request->get('filter_data')["ticket_priority_no"]) {
            $data = $data->where('ticket_priority_no', $ticket_priority_no);
        }
        if ($request->get('filter_data') && $equipment_id = $request->get('filter_data')["equipment_id"]) {
            $data = $data->where('equipment_no', $equipment_id);
        }


        if ($request->get('filter_data') && isset($request->get('filter_data')["ticket_internal_external"]) && $ticket_internal_external_yn = $request->get('filter_data')["ticket_internal_external"]) {
            $data = $data->where('ticket_internal_external_yn', $ticket_internal_external_yn);
        }

        $getKey = json_encode(Auth::user()->roles->pluck('role_key'));
        if (strpos($getKey, "CCMS_ADMIN") !== FALSE||strpos($getKey, "CCMS_TICKET_MANAGER") == true
            ||strpos($getKey, "CCMS_SYSTEM_ANALYST") == true) {
            $dataTable = $data->orderBy('ticket_no', 'desc')->get();
        }else{
            $assign_by = auth()->user()->user_id;
            $dataTable = $data->orderBy('ticket_no', 'desc')->where('insert_by',$assign_by)->get();
        }

        return Datatables::of($dataTable)
            ->addIndexColumn()
            ->addColumn('ticket_id', function ($data) {
                return '<a  href="' .route('service_ticket.ticket_dtl', ['id' => $data->ticket_no, 'f' => 'se']). '" class="">'.$data->ticket_id.'</a>';
            })
            ->addColumn('assigned_to', function ($data) {
                $assigned_to = DB::selectOne('SELECT SEI.SERVICE_ENGINEER_NAME
        FROM SERVICE_TICKET ST
         INNER JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = ST.ASSIGN_ENGINEER_ID)
         WHERE ST.TICKET_NO = :ticket_no', ['ticket_no' => $data->ticket_no]);
                if (!empty($assigned_to)) {
                    $html = <<<HTML
<span class="badge badge-success">&nbsp$assigned_to->service_engineer_name&nbsp</span>
HTML;
                    return $html;
                } else {
                   if ((auth()->user()->hasRole('CCMS_ADMIN') ||auth()->user()->hasRole('CCMS_TICKET_MANAGER'))){
                       return '<a href="javascript:void(0)" class="show-modal" data-id="'.$data->ticket_no.'+'.nl2br($data->ticket_description).'"><span class="badge badge-danger">Unassigned</span></a>';
                   }
                    return '<a href="javascript:void(0)" class="" data-id="'.$data->ticket_no.'+'.nl2br($data->ticket_description).'"><span class="badge badge-danger">Unassigned</span></a>';
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
                //dd($priority); //return $priority->remarks;
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
                $assigned_to = DB::selectOne('SELECT SEI.SERVICE_ENGINEER_NAME
        FROM SERVICE_TICKET ST
         INNER JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = ST.ASSIGN_ENGINEER_ID)
         WHERE ST.TICKET_NO = :ticket_no', ['ticket_no' => $data->ticket_no]);

                $optionHtml = '';
                if (!$assigned_to){
                    $optionHtml .= '<a href="' . route('service_ticket.index', ['id' => $data->ticket_no]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                }

                $optionHtml .= '<a href="' . route('service_ticket.ticket_dtl', ['id' => $data->ticket_no]) . '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
//                $optionHtml .= '<a class="confirm-delete text-danger" href="' . $data->ticket_no . '"><i class="bx bx-trash cursor-pointer"></i></a>';
                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
    }

    // $optionHtml .= '<a data-ticket_no="'.''.$data->ticket_no.''.'" data-ticket_id="'.''.$data->ticket_id.''.'" data-ticket_type_no="'.''.$data->ticket_type_no.''.'" data-ticket_description="'.''.$data->ticket_description.''.'" data-ticket_priority_no="'.''.$data->ticket_priority_no.''.'" data-emp_id="'.''.$data->emp_id.''.'" data-occurance_date="'.''.$data->occurance_date.''.'" data-meeting_start_time="'.''.$data->meeting_start_time.''.'" data-meeting_end_time="'.''.$data->meeting_end_time.''.'" data-meeting_room_no="'.''.$data->meeting_room_no.''.'" class="show-modal"><i class="bx bx-show cursor-pointer"></i></a>';


    /**
     * Get EquipmentList repo
     *
     * @return EquipmentListRepo
     */
    public function getServiceTicketRepo()
    {
        return $this->serviceTicketRepo;
    }

}
