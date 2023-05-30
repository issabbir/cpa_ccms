<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Entities\Ccms\EquipmentRequisitionList;
use App\Entities\Ccms\L_Requsition_Status;
use App\Entities\Ccms\RequisitionDetail;
use App\Entities\Ccms\RequisitionMasterList;
use App\Entities\CIMS\Item;
use App\Entities\CIMS\ItemBrands;
use App\Entities\CIMS\ItemVariantOptions;
use App\Entities\CIMS\LItem;
use App\Entities\CIMS\LItemCategory;
use App\Entities\CIMS\LStore;
use App\Entities\Security\Role;
use App\Entities\Security\SecUserRoles;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAddManager;
use App\Managers\Ccms\EquipmentListManager;
use App\Managers\Ccms\ServiceTicketManager;
use App\Managers\Ccms\ThirdPartyServiceManager;
use App\Managers\ProcedureManager;
use App\Managers\Ccms\RequisitionMasterManager;
use App\Managers\Ccms\GenSetupManager;
use App\Repositories\RequisitionDetailsRepo;
use App\Repositories\RequisitionMasterRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use function MongoDB\BSON\toJSON;

class RequisitionMasterController extends Controller
{
    /** @var RequisitionMasterRepo */
    protected $requisitionMasterRepo;
    protected $requisitionRepo;


    /**
     * RequisitionDetailsManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
    public function __construct(RequisitionMasterRepo $requisitionMasterRepo, RequisitionDetailsRepo $requisitionRepo)
    {
        $this->requisitionMasterRepo = $requisitionMasterRepo;
        $this->requisitionRepo = $requisitionRepo;
    }

    /**
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, ServiceTicketManager $serviceTicketManager, RequisitionMasterManager $requisitionMasterManager, GenSetupManager $genSetupManager, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $item_sql = "select CIMS.get_item_list(:p_department_id,:p_item_name) from dual";
        $items = DB::select($item_sql, ['p_department_id' => 10, 'p_item_name' => null]);//computer center=10
        $request_data = $request->get('id');
        if (preg_match('/\bequipment_no=\b/', $request_data)) {
            $id = explode('=', $request_data, 2)[1]; // Returns This_is_a_string
            $data = $serviceTicketManager->getServiceTicketRepo()->findOne($id);
            $employee = DB::selectOne('select emp_name, emp_id from pmis.employee where emp_id = :emp_id', ['emp_id' => $data->emp_id]);
            if (!empty($employee)) {
                $data->req_for_name = $employee->emp_name;
                $data->requisition_for = $employee->emp_id;
            }
            $equipment = DB::selectOne('select EQUIPMENT_NAME from EQUIPMENT_LIST where EQUIPMENT_NO = :EQUIPMENT_NO', ['EQUIPMENT_NO' => $data->equipment_no]);
            if (!empty($equipment)) {
                $data->equipment_name = $equipment->equipment_name;
            }
            $gen_req_id = DB::selectOne('select generate_requisation_id as requisition_id from dual')->requisition_id;
            $getTicketNo = $thirdPartyServiceManager->getThirdPartyServiceRepo()->getTicketNo();
            $requisitionStatus = L_Requsition_Status::all();
            $getEquipmentID = $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
            $employeeList = [];
            $requisition_mst_no = $id;
            $reqDtlData = DB::select("select * from EQUIPMENT_REQUISITION_DTL where REQUISITION_MST_NO = '$requisition_mst_no'");
            $readonly = false;
        } else {
            $data = $requisitionMasterManager->getRequisitionMasterRepo()->findOne($request->get('id'));
            if (!empty($request->get('id'))) {
                $employee = DB::selectOne('select emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => $data->requisition_for]);
                if (!empty($employee)) {
                    $data->req_for_name = $employee->emp_name;
                }
                $equipment = DB::selectOne('select EQUIPMENT_NAME from EQUIPMENT_LIST where EQUIPMENT_NO = :EQUIPMENT_NO', ['EQUIPMENT_NO' => $data->equipment_no]);
                if (!empty($equipment)) {
                    $data->equipment_name = $equipment->equipment_name;
                }
                $ticket = DB::selectOne('select ticket_id from SERVICE_TICKET where ticket_NO = :ticket_NO', ['ticket_NO' => $data->ticket_no]);
                if (!empty($ticket)) {
                    $data->ticket_id = $ticket->ticket_id;
                }
            }
            $gen_req_id = DB::selectOne('select generate_requisation_id as requisition_id from dual')->requisition_id;
            $getTicketNo = $thirdPartyServiceManager->getThirdPartyServiceRepo()->getTicketNo();
            $requisitionStatus = L_Requsition_Status::all();
            $getEquipmentID = $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
            $employeeList = [];
            $requisition_mst_no = $request->get('id');
            $reqDtlData = DB::select("select * from EQUIPMENT_REQUISITION_DTL where REQUISITION_MST_NO = '$requisition_mst_no'");
            $readonly = false;
        }

        return view("ccms.admin.manage_requisition.requisition_master", compact('data', 'gen_req_id', 'employeeList', 'readonly', 'getTicketNo', 'getEquipmentID', 'reqDtlData', 'requisitionStatus','items'));
    }

    public function detailView(Request $request, RequisitionMasterManager $requisitionMasterManager, GenSetupManager $genSetupManager, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $requisition_mst_no = $request->get('id');
        $requisitionMstData = $this->requisitionMasterRepo->findOne($requisition_mst_no);
        if (!empty($requisition_mst_no)) {
            $employee = DB::selectOne('select emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => $requisitionMstData->requisition_for]);
            if (!empty($employee)) {
                $requisitionMstData->req_for_name = $employee->emp_name;
            }
        }

        return view('ccms.admin.manage_requisition.requisition_dtl_view', compact('requisitionMstData'));
    }
    public function requisitionInventory(Request $request)
    {
        try {
//             $data = VwItemStock::where('item_id',$request->get('item_id'))->get();
            // dd($data);
            $view = view('ccms.admin.manage_requisition.inventory_list', [
                'item_id' => $request->get('item_id')
            ])->render();

            return $response = ["status" => true, "html" => $view];
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            $response = ["status" => false, "status_code" => 99, "message" => 'Please try again later.'];
        }
        // dd($response);
        return $response;
    }

    public function requisitionInventoryView(Request $request,EquipmentListManager $equipmentListManager, GenSetupManager $genSetupManager, EquipmentAddManager $equipmentAddManager)
    {
        try {
            $sqlStock = "SELECT b.item_id,
                       b.item_name,
                       a.department_id,
                       c.department_name,
                       d.store_id,
                       d.store_name,
                       e.brand_id,
                       e.brand_name,
                       a.variants_string,
                       h.unit_code,
                       a.stock_quantity
                FROM cims.vw_item_stock     a,
                     cims.l_item                 b,
                     cims.departments            c,
                     cims.l_store                d,
                     cims.l_brand                e,
                     cims.l_measurement_of_unit  h
                WHERE     a.item_id = b.item_id
                  AND a.department_id = c.department_id(+)
                  AND a.store_id = d.store_id(+)
                  AND a.brand_id = e.brand_id(+)
                  AND a.unit_id = h.unit_id(+)
                  AND a.item_id = :p_item_id
                  AND a.department_id = :department_id
                  AND nvl(a.brand_id,0) = nvl(:brand_id,nvl(a.brand_id,0))
                  AND nvl(a.variants_string,0) = nvl(:variants,nvl(a.variants_string,0))";

            $stockView = DB::selectOne($sqlStock, [
                'p_item_id' => $request->get('item_id'),
                'brand_id' => $request->get('brand_id'),
                'department_id' => $request->get('department_id'),
                'variants' => $request->get('variants'),
            ]);

            $sql  = "SELECT cims.get_stock_purchase_info(:p_ITEM_ID,:p_BRAND_ID,:P_VARIANTS_STRING) from dual";

            $data = DB::selectOne($sql,[
                'p_ITEM_ID'=>$request->get('item_id'),
                'p_BRAND_ID'=>$request->get('brand_id'),
                'P_VARIANTS_STRING'=>$request->get('variants'),
            ]);

            $vendorTypes = $genSetupManager->getVendorRepo()->findAll();
            $categories = HelperClass::categoryMenu();
            $gen_equ_id = DB::selectOne('select generate_equipment_id  as equipment_id from dual')->equipment_id;
//            $departments = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllDepartment();
            $view = view('ccms.admin.manage_requisition.view_data', [
                'stock' => $data,
                'stockView' => $stockView,
            ])->render();

            return $response = ["status" => true, "html" => $view];
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::info($e->getMessage());
            DB::rollBack();
            $response = ["status" => false, "status_code" => 99, "message" => 'Please try again later.'];
        }
        // dd($response);
        return $response;
    }


    /**
     * Requisition Master  table data list
     *
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     * @return mixed
     * @throws \Exception $requisition = $this->requisitionMasterRepo->getRequisitionMaster();
     */
    public function list(Request $request, RequisitionMasterManager $requisitionMasterManager)
    {
//dd($request->all());
        $requisition = $this->requisitionMasterRepo->getRequisitionMaster();
        //dd($requisition);
        if ($request->get('filter_data') && $req_status = $request->get('filter_data')["req_status"]) {
            $requisition = $requisition->where('requisition_status_id', $req_status);
        }
        if ($request->get('filter_data') && $request->get('filter_data')["status"] == 4) {
            $requisition = $requisition->where('requisition_status_id', $request->get('filter_data')["status"] );
        }else if ($request->get('filter_data') && $request->get('filter_data')["status"] == 'all') {

        }
//        else{
//            $requisition = $requisition->whereNotIn('requisition_status_id', [4]);
//        }

        if ($request->get('filter_data') && $requisition_for = $request->get('filter_data')["requisition_for_filter"]) {
            $requisition = $requisition->where('requisition_for', $requisition_for);
        }

        if ($request->get('filter_data') && $equipment_no = $request->get('filter_data')["equipment_no"]) {
            $requisition = $requisition->where('equipment_no', $equipment_no);
        }

        if ($request->get('filter_data') && $from_date = $request->get('filter_data')['requisition_date']) {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
            $requisition = $requisition->where('requisition_date', '>=', $from_date);
        }

        if ($request->get('filter_data') && $to_date = $request->get('filter_data')['requisition_end_date']) {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $requisition = $requisition->where('requisition_date', '<=', $to_date);
        }

        return datatables()->of($requisition->get())
            ->addIndexColumn()
            ->addColumn('requisition_date', function ($data) {
                return Carbon::parse($data->requisition_date)->format('d-m-Y h:i A');
            })
            ->addColumn('equipment_no', function ($data) {
                if ($data->equipment_no != null) {
                    $status = DB::selectOne('select EQUIPMENT_NAME from EQUIPMENT_LIST where EQUIPMENT_NO =:EQUIPMENT_NO',
                        ['EQUIPMENT_NO' => $data->equipment_no]);
                    return $status->equipment_name;
                } else {
                    return '';
                }
            })
            ->addColumn('requisition_for', function ($data) {
                if (!empty($data->requisition_for)) {
                    $employee = DB::selectOne('select emp_name, emp_code from pmis.employee where emp_id =:emp_id',
                        ['emp_id' => $data->requisition_for]);
                    return $employee->emp_name . " (" . $employee->emp_code . ")";
                } else {
                    return '';
                }
            })
            ->addColumn('requistion_by', function ($data) {
                if (!empty($data->requistion_by)) {
                    $employee = DB::selectOne('select secu.USER_NAME from cpa_security.sec_users secu
left join EQUIPMENT_REQUISITION_MST erm on (erm.REQUISTION_BY = secu.USER_ID)
where erm.REQUISTION_BY = :REQUISTION_BY
and erm.REQUISITION_MST_NO = :REQUISITION_MST_NO',
                        ['REQUISTION_BY' => $data->requistion_by, 'REQUISITION_MST_NO' => $data->requisition_mst_no]);
                    if (isset($employee->emp_name)) {
                        return $employee->emp_name;
                    } else {
                        return $employee->user_name;
                    }

                } else {
                    return '';
                }
            })
            ->addColumn('requisition_status_id', function ($data) {
                if (!empty($data->requisition_status_id)) {
                    $reqStatus = DB::selectOne('select STATUS_NAME from L_REQUISITION_STATUS
where REQUISITION_STATUS_ID = :REQUISITION_STATUS_ID', ['REQUISITION_STATUS_ID' => $data->requisition_status_id]);
                    if (!empty($reqStatus)) {
                        return $reqStatus->status_name;
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }
            })
            ->addColumn('approved_yn', function ($data) {

                if ($data->requisition_status_id == '4') {
                    $html = '<span class="badge badge-success">&nbsp&nbsp&nbspApproved&nbsp&nbsp&nbsp</span>';

                    return $html;

                    //return 'Approved';
                } else {
                    $html = <<<HTML
<span class="badge badge-danger">Not approved</span>
HTML;
                    return $html;
                    //return 'Not Approved';
                }
            })
            ->addColumn('action', function ($data) {
                $optionHtml = '';
                if(auth()->user()->hasRole('CCMS_SERVICE_ENGINEER') || auth()->user()->hasRole('CCMS_ADMIN')){
                    if ($data->requisition_status_id == '1' || (auth()->user()->hasRole('CCMS_ADMIN') && $data->requisition_status_id == '2')) {
                        $optionHtml .= '<a href="' . route('admin.requisition-master.index', ['id' => $data->requisition_mst_no]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                    }
                    //                    $optionHtml .= ' <a title="Add Requisition Details" href="' . route('admin.requisition-details.index', ['requisition_mst_no' => $data->requisition_mst_no]) . '"><i class="bx bx-plus"></i></a>';
                    $optionHtml .= '<a href="' . route('admin.requisition-master.detail-view', ['id' => $data->requisition_mst_no]) . '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
//                $optionHtml .= ' <a class="confirm-delete text-danger" href="' . $data->requisition_mst_no . '"><i class="bx bx-trash cursor-pointer"></i></a>';
//                $optionHtml .= ' <a class="confirm-approved text-success" href="' . $data->requisition_mst_no . '+' . $data->approved_yn . '"><i class="bx bx-check-circle cursor-pointer"></i></a>';

                    return $optionHtml;
                }else{
                    $optionHtml = '<a href="' . route('admin.requisition-master.detail-view', ['id' => $data->requisition_mst_no]) . '" class=""><i class="bx bx-show cursor-pointer"></i></a>';

                    return $optionHtml;
                }

            })->escapeColumns([])->make(true);
    }

    public function detailDatatable(Request $request)
    {//dd(auth()->user()->hasRole('CCMS_MEMBER_FINANCE'));
    if(!auth()->user()->hasRole('CCMS_MEMBER_FINANCE')){
        $data = $this->requisitionRepo->getRequisitionDetails()->where('requisition_mst_no', $request->get('req_mst_id'))->get();
    }else{
        $data = $this->requisitionRepo->getRequisitionDetails()->where('requisition_mst_no', $request->get('req_mst_id'))->whereNotNull('approve_sa_qty')->get();
    }

    //dd($data);
        return datatables()->of($data)
            ->addColumn('approve_qty', function ($data) {
                if(auth()->user()->hasRole('CCMS_MEMBER_FINANCE')){
                    $html = <<<HTML
<input type="number" name="approve_qty[]"  class="form-control approve_qty" value="{$data->approve_sa_qty}"
onkeypress="return event.charCode >= 48" min="1" max="{$data->approve_sa_qty}" autocomplete="off" />
HTML;
                    return $html;
                }else{
                    $html = <<<HTML
<input type="number" name="approve_qty[]"  class="form-control approve_qty" value="{$data->quantity}"
onkeypress="return event.charCode >= 48" min="1" max="{$data->quantity}" autocomplete="off" />
HTML;
                    return $html;
                }

            })
            ->addColumn('selected', function ($data) {
                $html = <<<HTML
<input type="hidden" name="requisition_dtl_no[]" value="{$data->requisition_dtl_no}" />
<input type="hidden" name="requisition_mst_no[]" value="{$data->requisition_mst_no}" />


<input type="checkbox" name="selected[]" value="{$data->requisition_dtl_no}"/>
HTML;
                return $html;
            })->rawColumns(['selected', 'approve_qty'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * <input type="checkbox" name="selected[{$data->requisition_dtl_no}]"/>
     *
     * @param null $id
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     */

    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        //$result =  $requisitionMasterManager->saveRequisitionMaster($id, $request);
       // dd($request->all());
        $postData = $request->post();

        $requisition_date = isset($postData['requisition_date']) ? date('Y-m-d', strtotime($postData['requisition_date'])) : date('Y-m-d', time());
        try {
            DB::beginTransaction();
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $requisition_no = sprintf("%4000s", "");
            if ($id != null && is_numeric($id)) {
                $params = [
                    'p_REQUISITION_MST_NO' => $postData['requisition_mst_no'],
                    'p_REQUISITION_ID' => $postData['requisition_id'],
                    'p_REQUISITION_DATE' => $requisition_date,
                    'p_REQUISITION_NOTE' => $postData['requisition_note'],
                    'P_UPDATE_BY' => auth()->id(),
                    'p_TICKET_YN' => 'Y',
                    'p_TICKET_NO' => $postData['ticket_no'],
                    'p_EQUIPMENT_NO' => $postData['equipment_no'],
                    'p_REQUISITION_FOR' => $postData['requisition_for'],
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];
                DB::executeProcedure('REQUISITION.requisition_upd', $params);//dd($params);
            } else {
                $params = [
                    'p_REQUISITION_ID' => $postData['requisition_id'],
                    'p_REQUISITION_DATE' => $requisition_date,
                    'p_REQUISITION_NOTE' => $postData['requisition_note'],
                    'p_TICKET_YN' => 'Y',
                    'p_TICKET_NO' => $postData['ticket_no'],
                    'p_EQUIPMENT_NO' => $postData['equipment_no'],
                    'P_INSERT_BY' => auth()->id(),
                    'p_REQUISTION_BY' => auth()->id(),
                    'p_REQUISITION_FOR' => $postData['requisition_for'],
                    'o_REQUISITION_NO' => &$requisition_no,
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];
                DB::executeProcedure('REQUISITION.requisition_ins', $params);
            }

            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }

            if ($postData['tab_item_name']) {
                if ($id != null) {
                    $requisition_no = $postData['requisition_mst_no'];
                    EquipmentRequisitionList::where('requisition_mst_no', $postData['requisition_mst_no'])->delete();
                }
                // dd($postData);
                foreach ($postData['tab_item_name'] as $indx => $value) {
                    $requisition_dtl_no = null;
                    $status_code = sprintf("%4000s", "");
                    $status_message = sprintf("%4000s", "");
                    $params_dtl = [
                        "p_REQUISITION_DTL_NO" => [
                            'value' => &$requisition_dtl_no,
                            'type' => \PDO::PARAM_INPUT_OUTPUT,
                            'length' => 255
                        ],
                        "p_REQUISITION_MST_NO" => $requisition_no,
                        "p_QUANTITY" => $postData['tab_quantity'][$indx],
                        "p_DESCRIPTION" => $postData['tab_description'][$indx],
                        "p_REMARKS" => $postData['tab_remarks'][$indx],
                        "p_ITEM" => $postData['tab_item_name'][$indx],
                        "p_ITEM_ID" => $postData['tab_item_id'][$indx],
                        "P_INSERT_BY" => auth()->id(),
                        "p_UPDATE_BY" => auth()->id(),
                        "p_APPX_PRICE" => null,
                        "p_REPLACEMENT_YN" => $postData['tab_replacement_yn'][$indx],
                        "p_brand_id" => $postData['brands_id'][$indx],
                        "p_brand_name" => $postData['brand_name'][$indx],
                        "p_variants" => $postData['variants_string'][$indx],
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message
                    ];

                   // dd($params_dtl);
                    DB::executeProcedure("REQUISITION.requisition_dtl_crud", $params_dtl);

                    if ($params_dtl['o_status_code'] != 1) {
                        DB::rollBack();
                        return $params_dtl;
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();


        if ($params['o_status_code'] == 1) {
            $url='admin/requisition-master-detail-view?id='.$params['o_REQUISITION_NO'].'&f=se';
            $note='Need to forward to system analyst for Requisition.';
            HelperClass::sendNotification('CCMS_ADMIN',$note,$url);
            Session::flash('success', $params['o_status_message']);
            return redirect()->route('admin.requisition-master.index');
        }

        Session::flash('error', $params['o_status_message']);
        if ($id)
            return redirect()->route('admin.requisition-details.index', ['id' => $id]);

        return redirect()->route('admin.requisition-master.index');
    }

    /**
     * @param $requisitionMstNo
     * @param RequisitionMasterManager $requisitionMasterManager
     */
    public function del($requisitionMstNo, RequisitionMasterManager $requisitionMasterManager)
    {
        $result = $requisitionMasterManager->delRequisition($requisitionMstNo);
    }

    public function removeDtlData(Request $request)
    {
        try {
            $querys = "DELETE FROM EQUIPMENT_REQUISITION_DTL WHERE REQUISITION_DTL_NO = '" . $request->get("requisition_dtl_no") . "'";
            $result = DB::select(DB::raw($querys));
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }

    public function requisitionMasterDataApproved(Request $request)
    {
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'p_REQUISITION_MST_NO' => $request->get('requisition_mst_no'),
            'p_APPROVED_YN' => $request->get('APPROVED_YN'),
            'p_UPDATE_BY' => auth()->id(),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        DB::executeProcedure('REQUISITION.requisition_approval', $params);
        return $params['o_status_code'];
    }

    public function removeRequisition(Request $request)
    {
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'p_REQUISITION_MST_NO' => $request->get('requisition_mst_no'),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        DB::executeProcedure('REQUISITION.requisition_del', $params);
        return $params['o_status_code'];
    }

    public function forwardRequisition(Request $request)
    {
        $postData = $request->post();//dd($request);

        //dd($postData);
        try {
            DB::beginTransaction();
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            if ($postData['status_key'] === 'FWD_SA') {
                $params = [
                    'p_REQUISITION_MST_NO' => $postData['req_mst_no'],
                    'p_REQUISITION_DTL_NO' => '',
                    'P_APPROVE_QTY' => '',
                    'p_APPROVE_BY' => '',
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];
                DB::executeProcedure('REQUISITION.FORWARDING_TO_SA', $params);

                if ($params['o_status_code'] == 1){
                    $url='admin/requisition-master-detail-view?id='.$postData['req_mst_no'].'&f=se';
                    $note='Need requisition forward to store administrator.';
                    HelperClass::sendNotification('CCMS_SYSTEM_ANALYST',$note,$url);
                }

            } elseif ($postData['status_key'] === 'FWD_MF') {
//                foreach ($request->get('requisition_dtl_no') as $indx => $value) {
                foreach ($request->get('selected') as $indx => $value) {
                    if ($value) {
                        $requisition_dtl = RequisitionDetail::where('requisition_dtl_no',$value)->first();
                        // dd($requisition_dtl);
                        $stockCheck = HelperClass::stockCheck($requisition_dtl->item_id,$requisition_dtl->brand_id,$requisition_dtl->variants);
                        // dd($stockCheck);
                        if (!filled($stockCheck)){
                            DB::rollBack();
                            Session::flash('o_status_code', 99);
                            Session::flash('error', 'Stock Not available for '.$requisition_dtl->item);
                            return redirect()->route('admin.requisition-master.index');
                        }
                        $key_val = $request->get('requisition_dtl_no')[$indx];
//                        $exist = array_key_exists($key_val, $request->get("selected"));
                        $exist = in_array($key_val, $request->get("selected"));
                        //dd($exist);
                        if ($exist) {
                            $key_index = array_search($key_val, $request->get('requisition_dtl_no'));
                            $approve_qty = $request->get('approve_qty')[$key_index];
                            $params = [
                                'p_REQUISITION_MST_NO' => $request->get('requisition_mst_no')[$indx],
                                'p_REQUISITION_DTL_NO' => $request->get('requisition_dtl_no')[$indx],
                                'P_APPROVE_QTY' => $approve_qty,
                                'p_APPROVE_BY' => auth()->id(),
                                'o_status_code' => &$status_code,
                                'o_status_message' => &$status_message,
                            ];
                            DB::executeProcedure('REQUISITION.FORWARDING_TO_MF', $params);
                            if ($params['o_status_code'] == 1){
                                $url='admin/requisition-master-detail-view?id='.$postData['req_mst_no'].'&f=se';
                                $note='Need requisition delivering to service engineer.';
                                HelperClass::sendNotification('CCMS_MEMBER_FINANCE',$note,$url);
                            }
                        } else {
                        }
                    }
                }

            } elseif ($postData['status_key'] === 'PURCHASE') {
                 // dd($request->all());
//                foreach ($request->get('requisition_dtl_no') as $indx => $value) {
                $items = [];
                foreach ($request->get('selected') as $indx => $value) {
                    if ($value) {
                        $requisition_dtl = RequisitionDetail::where('requisition_dtl_no',$value)->first();
                        //  dd($requisition_dtl);
                        $stockCheck = HelperClass::stockCheck($requisition_dtl->item_id,$requisition_dtl->brand_id,$requisition_dtl->variants);
                         // dd($stockCheck);
                        if (!filled($stockCheck)){
                            $items[] = $requisition_dtl->item;
                           // dd($items);
                            DB::rollBack();
                            Session::flash('o_status_code', 99);
                            Session::flash('error', 'Stock Not available for '.implode(',',$items));
                            return redirect()->route('admin.requisition-master.index');
                        }
                        $key_val = $request->get('requisition_dtl_no')[$indx];
//                        $exist = array_key_exists($key_val, $request->get("selected"));
                        $exist = in_array($key_val, $request->get("selected"));
                        if ($exist) {
                            $key_index = array_search($key_val, $request->get('requisition_dtl_no'));
                            $approve_qty = $request->get('approve_qty')[$key_index];
                            $params = [
                                'p_REQUISITION_MST_NO' => $request->get('requisition_mst_no')[$indx],
                                'p_REQUISITION_DTL_NO' => $request->get('requisition_dtl_no')[$indx],
                                'P_APPROVE_QTY' => $approve_qty,
                                'p_APPROVE_BY' => auth()->id(),
                                'o_status_code' => &$status_code,
                                'o_status_message' => &$status_message,
                            ];
                            DB::executeProcedure('REQUISITION.APPROVING_BY_MF', $params);
                        } else {
                        }
                    }
                }
            }


            if ($params['o_status_code'] != 1) {
                DB::rollBack();
                return $params;
            }
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params_status = [
                'p_REQUISITION_MST_NO' => $postData['req_mst_no'],
                'p_STATUS_KEY' => $postData['status_key'],
                'p_INSERT_BY' => '',
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            DB::executeProcedure('REQUISITION.CHANGE_STATUS', $params_status);//dd($params);

        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();

        if ($params['o_status_code'] == 1) {
            Session::flash('success', $params['o_status_message']);
        } else {
            Session::flash('error', $params['o_status_message']);
        }
        return redirect()->route('admin.requisition-master.index');
        //return redirect()->route('admin.requisition-master.detail-view', ['id' => $postData['req_mst_no']]);
    }

    public function rejectRequisition(Request $request)
    {
        $result = RequisitionMasterList::where('requisition_mst_no',$request->get("req_mst_no"))->update(['reject_note'=> $request->get("reject_note"), 'requisition_status_id'=> '6']);

        if ($result == 1) {
            Session::flash('success', 'REQUISITION REJECTED.');
            return redirect()->to(url('/admin/requisition-master-detail-view?id='.$request->get("req_mst_no")));
        }

        Session::flash('error', 'UNSUCCESSFUL');
        return redirect()->route('admin.requisition-master.detail-view', ['id' => $request->get("req_mst_no")]);
    }

    public function itemSearchAjax(Request $request){


  //    $search_department = Auth::user()->employee->dpt_department_id;
        $search_department = 10;

        //$result = $this->item;
        if(!empty($request->get('keyword'))) {
            $result = LItem::with('category','unit','department','variants','brand')->where(DB::raw('LOWER(item_name)'),'like',strtolower('%'.trim($request->get('keyword')).'%'));

            if ($search_department){
                $result->whereHas('department', function ($query) use ($search_department) {
                    $query->where('department_id', $search_department);
                });
            }


            $data = $result->take(5)->get();
            $html = '<ul id="item-list">';
            if(filled($data)) {
                foreach($data as $item) {
                    $html .= "<li class='itemDataShow' data-url='".route('item-view-ajax')."' data-id='$item->item_id' data-name='$item->item_name'>$item->item_name</li>";
                }
            }else{
                  $html .= "<li class='itemDataShow'>No data found</li>";
            }
            $html .= '</ul>';
            return $html;
        }
    }
    public function itemViewAjax(Request $request){
        $data = LItem::with('category','unit','department','variants','brand')->find($request->get('item_id'));
        $variantData = ItemVariantOptions::select('item_id','variant_id')->where('item_id',$data->item_id)->groupBy('variant_id','item_id')->get();
        $brandData = ItemBrands::select('item_id','brand_id')->where('item_id',$data->item_id)->get();

        $variantSelects = '<option value="">Select One</option>';
        if(filled($variantData)){
            foreach ($variantData as $variant){
                $variantSelects .= '<option data-id="'.$variant->item_id.'" value="'.$variant->variant_id.'">'.$variant->variant_name->variant_name.'</option>';
            }
        }
        $brandSelects = '<option value="">Select One</option>';
        if(filled($brandData)){
            foreach ($brandData as $brand){
                $brandSelects .= '<option data-id="'.$brand->item_id.'" value="'.$brand->brand_id.'">'.$brand->brand->brand_name.'</option>';
            }
        }
        return response()->json(['status' =>true,'variantSelects' => $variantSelects,'brandSelects'=>$brandSelects,'data' =>$data]);
    }
    public function itemVariantOption(Request $request){
        $variantOptionData = ItemVariantOptions::where('item_id',$request->get('item_id'))->where('variant_id',$request->get('variant_id'))->get();

        // dd($variantOptionData);
        $variantSelects = '<option value="">Select One</option>';
        if (filled($variantOptionData)){
            //dd($variantOptionData->variant_options);
            foreach ($variantOptionData as $variant){
                // dd($variant->variant_options);
                if ($variant->variant_options) {
                    $variantSelects .= '<option value="' . $variant->variant_option_id . '">' . $variant->variant_options->variant_option_name . '</option>';
                }
            }
        }

        return response()->json(['status' =>true,'variantOptionSelects' => $variantSelects]);
    }

    public function itemVariantProcess(Request $request){
        $variants = $request->get('variants');
        $variant_name = [];
        $variant_ids = [];
        if (filled($variants)){
            foreach ($variants as $variant){
                $variant = (array)$variant;
                $variant_ids [$variant['variant_id']] = ["variant_name" => $variant['variant_name'],"option_name" => $variant['variant_option_name']];
             }

            usort($variant_ids, function($a, $b) {
                return $a['variant_name'] <=> $b['variant_name'];
            });
            foreach ($variant_ids as $k => $v) {
                $variant_name[] = $v['variant_name'].'-'.$v['option_name'];
            }
        }

        return response()->json(['status' =>true,'data' => filled($variant_name) ? implode(',',$variant_name) : '']);
    }
}
