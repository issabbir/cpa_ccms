<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Entities\Ccms\ThirdPartyService;
use App\Entities\Security\Role;
use App\Entities\Security\SecUserRoles;
use App\Entities\Security\User;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\Repositories\ThirdPartyServiceRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ThirdPartyServiceManager;
use Illuminate\Http\Request;
use PDO;
use Yajra\DataTables\DataTables;

class ThirdPartyServiceController extends Controller
{
    /** @var RequisitionMasterRepo  */
    protected $thirdPartyServiceRepo;


    /**
     * ThirdPartyServiceManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
    public function __construct(ThirdPartyServiceRepo $thirdPartyServiceRepo)
    {
        $this->thirdPartyServiceRepo = $thirdPartyServiceRepo;
    }

    public function index(Request $request, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
    	$data = $thirdPartyServiceManager->getThirdPartyServiceRepo()->findOne($request->get('id'));
        $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        $getEquipmentID =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
        $getTicketNo =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getTicketNo();
        $getVendorNo =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getVendorNo();
        // dd($getVendorNo);
        return view('ccms.admin.services.third_party_service', compact('data', 'gen_uniq_id', 'getEquipmentID', 'getTicketNo', 'getVendorNo'));
    }

    public function detailView(Request $request)
    {
        $third_party_service_id = $request->get('id');
        $thirdPartyMstData = DB::selectOne("select tps.*, EL.EQUIPMENT_NAME, VL.VENDOR_NAME FROM THIRD_PARTY_SERVICE TPS
LEFT JOIN EQUIPMENT_LIST EL ON (TPS.EQUIPMENT_NO = EL.EQUIPMENT_NO)
LEFT JOIN VENDOR_LIST VL ON (TPS.VENDOR_NO = VL.VENDOR_NO)
WHERE TPS.THIRD_PARTY_SERVICE_ID = :third_party_service_id", ['third_party_service_id' => $third_party_service_id]);
        return view('ccms.admin.services.third_party_service_dtl_view', compact('thirdPartyMstData'));
    }

    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param ThirdPartyServiceManager $thirdPartyServiceManager
     * @return mixed
     * @throws \Exception
     */

    public function list(Request $request, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
    	//return $thirdPartyServiceManager->getThirdPartyServiceTables($request);
        $data = $this->thirdPartyServiceRepo->findAll();
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


    public function forward($id = null, Request $request)
    { //dd($request);
        $data = ThirdPartyService::find($id);

         //dd($data);
        if ($data->forward_yn == 'Y'){
            Session::flash('error', 'Third party service already forward!');
            return redirect()->route('admin.third_party.index');
        }
        try {
            $result = ThirdPartyService::where("third_party_service_id", $id)
                          ->update([
                              "forward_yn" => 'Y',
                              "forward_by" => Auth::id(),
                              "update_date" => date('Y-m-d H:i:s')
                          ]);

            if ($result) {
                $url='admin/third-party-service-detail-view?id='.$id.'&f=se';
                $note='Need to approved for third party service.';
                HelperClass::sendNotification('CCMS_SYSTEM_ANALYST',$note,$url);
                Session::flash('success', 'Third party service forward to system analyst');
                return redirect()->route('admin.third_party.index');
            }

            Session::flash('error', 'Third party service not forward to system analyst');
            if ($id)
                return redirect()->route('admin.third_party.index', ['id' => $id]);

            return redirect()->route('admin.third_party.index');
        }catch (\Exception $e){
            Session::flash('error', $e->getMessage());
            return redirect()->route('admin.third_party.index');
        }

    }

    public function approve($id = null, Request $request)
    { //dd($request);
        $data = ThirdPartyService::find($id);

         //dd($data);
        if ($data->approved_yn == 'Y'){
            Session::flash('error', 'Third party service already approved!');
            return redirect()->route('admin.third_party.index');
        }
        try {
            $result = ThirdPartyService::where("third_party_service_id", $id)
                          ->update([
                              "approved_yn" => 'Y',
                              "approved_by" => Auth::id(),
                              "update_date" => date('Y-m-d H:i:s')
                          ]);

            if ($result) {
                Session::flash('success', 'Third party service approved');
                return redirect()->route('admin.third_party.index');
            }

            Session::flash('error', 'Third party service not approved');
            if ($id)
                return redirect()->route('admin.third_party.index', ['id' => $id]);

            return redirect()->route('admin.third_party.index');
        }catch (\Exception $e){
            Session::flash('error', $e->getMessage());
            return redirect()->route('admin.third_party.index');
        }

    }

    public function store($id = null, Request $request, ProcedureManager $procedureManager,ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $result = $procedureManager->execute('TICKET.THIRD_PARTY_SERVICE_CRUD', $request)->getParams();
        if ($result['o_status_code'] == 1) {
            $url='admin/third-party-service-detail-view?id='.$result['third_party_service_id']['value'].'&f=se';
            $note='Need to forward to system analyst for third party service.';
            HelperClass::sendNotification('CCMS_ADMIN',$note,$url);
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('admin.third_party.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('admin.third_party.index', ['id' => $id]);

         return redirect()->route('admin.third_party.index');
    }
    public function update($id = null, Request $request, ProcedureManager $procedureManager,ThirdPartyServiceManager $thirdPartyServiceManager)
    {

       // dd($request->all());
        $third_party_service_id = $request->get('third_party_service_id') ? $request->get('third_party_service_id') : '';
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'third_party_service_id' => [
                'value'     => &$third_party_service_id,
                "type"      => PDO::PARAM_INPUT_OUTPUT,
                "length"    => 255
            ],
            'p_equipment_no' => $request->get('equipment_no'),
            'p_ticket_no' => $request->get('ticket_no'),
            'p_vendor_no' => $request->get('vendor_no'),
            'p_problem_description' => $request->get('problem_description'),
            'p_service_charge' => $request->get('service_charge'),
            'p_sending_date' => date('Y-m-d',strtotime($request->get('sending_date'))),
            'p_received_date' => date('Y-m-d',strtotime($request->get('received_date'))),
            'p_problem_solved_yn' => null,
            'p_insert_by' => auth()->user()->employee->emp_id,
            'p_insert_date' => date('Y-m-d H:i:s'),
            'p_update_by' => auth()->user()->employee->emp_id,
            'p_update_date' => date('Y-m-d H:i:s'),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        //dd($params);
        DB::executeProcedure("ccms.ticket.third_party_service_crud", $params);


        if ($params['o_status_code'] == 1) {
            if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') && $request->approve_yn == 'Y'){
                $this->approve($id, $request);
                $url='admin/third-party-service-detail-view?id='.$params['third_party_service_id']['value'].'&f=se';
                $note='Third party service approved by system analyst.';
                HelperClass::sendNotification('CCMS_SERVICE_ENGINEER',$note,$url);
                Session::flash('success', 'Third party service approved');
                return redirect('/dashboard');
             }else{
                Session::flash('success', $params['o_status_message']);
                return redirect()->route('admin.third_party.index');
            }

        }

        Session::flash('error', $params['o_status_message']);
        if ($id)
         return redirect()->route('admin.third_party.index', ['id' => $id]);

         return redirect()->route('admin.third_party.index');
    }

    public function approveModal($id,Request $request)
    {
        $service = ThirdPartyService::find($id);
       // dd($service);
        $html =  view('ccms.admin.services.third_party_service_approve', [
            'data' => $service
        ])->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function removeThirdPartyService(Request $request)
    {
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'P_THIRD_PARTY_SERVICE_ID' => $request->get('third_party_service_id'),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        DB::executeProcedure('TICKET.THIRD_PARTY_SERVICE_DELETE', $params);
        return $params['o_status_code'];
    }
}
