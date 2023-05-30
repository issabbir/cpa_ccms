<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Entities\Ccms\EquipmentRequisitionList;
use App\Entities\Ccms\RequisitionDetail;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAddManager;
use App\Managers\Ccms\RequisitionMasterManager;
use App\Repositories\RequisitionDetailsRepo;
use App\Repositories\ThirdPartyServiceRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ThirdPartyServiceManager;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PurchaseOrderController extends Controller
{
    /** @var RequisitionMasterRepo  */
    protected $requisitionMasterManager;


    /**
     * ThirdPartyServiceManager constructor.
     *
     * @param RequisitionMasterManager $requisitionMasterManager
     */
    public function __construct(RequisitionMasterManager $requisitionMasterManager)
    {
        $this->requisitionMasterManager = $requisitionMasterManager;
    }

    /**
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     * @param EquipmentAddManager $equipmentAddManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request, RequisitionMasterManager $requisitionMasterManager, EquipmentAddManager $equipmentAddManager, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
        $data = $equipmentAddManager->getEquipmentAddRepo()->findOne($request->get('id'));
        $getEquipmentList = $equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentList();
        $getVendorList = $equipmentAddManager->getEquipmentAddRepo()->findAllVendorList();
        $gen_equpment_add_id = DB::selectOne('select generate_equipment_add_id  as equipment_add_id from dual')->equipment_add_id;
        //$getEquipmentID = $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
        $getEquipmentID = DB::table('ccms.EQUIPMENT_REQUISITION_DTL')
            ->leftJoin('ccms.EQUIPMENT_REQUISITION_MST','ccms.EQUIPMENT_REQUISITION_DTL.REQUISITION_MST_NO','=','ccms.EQUIPMENT_REQUISITION_MST.REQUISITION_MST_NO')
            ->leftJoin('ccms.EQUIPMENT_LIST','ccms.EQUIPMENT_REQUISITION_MST.EQUIPMENT_NO','=','ccms.EQUIPMENT_LIST.EQUIPMENT_NO')
            ->whereNotNull('ccms.EQUIPMENT_REQUISITION_DTL.approve_sa_qty')
            ->select('ccms.EQUIPMENT_LIST.EQUIPMENT_NAME','ccms.EQUIPMENT_LIST.EQUIPMENT_ID','ccms.EQUIPMENT_LIST.EQUIPMENT_NO')
            ->orderBy('APPROVE_SA_DATE','DESC')
            ->get();
        $getRequisitionMasterNo1=DB::table('ccms.EQUIPMENT_REQUISITION_DTL')
            ->leftJoin('ccms.EQUIPMENT_REQUISITION_MST','ccms.EQUIPMENT_REQUISITION_DTL.REQUISITION_MST_NO','=','ccms.EQUIPMENT_REQUISITION_MST.REQUISITION_MST_NO')
            ->leftJoin('ccms.EQUIPMENT_LIST','ccms.EQUIPMENT_REQUISITION_MST.EQUIPMENT_NO','=','ccms.EQUIPMENT_LIST.EQUIPMENT_NO')
            ->whereNotNull('ccms.EQUIPMENT_REQUISITION_DTL.approve_sa_qty')
            ->select('ccms.EQUIPMENT_REQUISITION_MST.REQUISITION_MST_NO')
            ->get();
        return view('ccms.admin.purchase_order.purchase_order', compact('data', 'gen_equpment_add_id',
                         'getEquipmentList', 'getVendorList','getEquipmentID','getRequisitionMasterNo1'));
    }

    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param ThirdPartyServiceManager $thirdPartyServiceManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, RequisitionMasterManager $requisitionMasterManager)
    {
        $data=DB::table('EQUIPMENT_REQUISITION_DTL')
            ->leftJoin('EQUIPMENT_REQUISITION_MST','EQUIPMENT_REQUISITION_DTL.REQUISITION_MST_NO','=','EQUIPMENT_REQUISITION_MST.REQUISITION_MST_NO')
            ->leftJoin('EQUIPMENT_LIST','EQUIPMENT_REQUISITION_MST.EQUIPMENT_NO','=','EQUIPMENT_LIST.EQUIPMENT_NO')
            ->leftJoin('CPAACC.FAS_AP_VENDORS','CPAACC.FAS_AP_VENDORS.VENDOR_ID','=','EQUIPMENT_LIST.VENDOR_NO')
            ->whereNotNull('EQUIPMENT_REQUISITION_DTL.approve_sa_qty')
            ->select('EQUIPMENT_LIST.EQUIPMENT_NAME','EQUIPMENT_LIST.EQUIPMENT_ID','EQUIPMENT_LIST.EQUIPMENT_NO','EQUIPMENT_LIST.VENDOR_NO','CPAACC.FAS_AP_VENDORS.VENDOR_NAME',
                'EQUIPMENT_REQUISITION_MST.REQUISITION_MST_NO', 'EQUIPMENT_REQUISITION_DTL.requisition_dtl_no','EQUIPMENT_REQUISITION_DTL.item','EQUIPMENT_REQUISITION_DTL.item_id',
                'EQUIPMENT_REQUISITION_DTL.brand_id','EQUIPMENT_REQUISITION_DTL.brand_name','EQUIPMENT_REQUISITION_DTL.variants',
                'EQUIPMENT_REQUISITION_DTL.description', 'EQUIPMENT_REQUISITION_DTL.appx_price', 'EQUIPMENT_REQUISITION_DTL.approve_mf_qty',
                'EQUIPMENT_REQUISITION_DTL.approve_mf_qty', 'EQUIPMENT_REQUISITION_DTL.received_yn')
            ->get();

        if ($request->get('filter_data') && $equipment_no = $request->get('filter_data')["equipment_no"]) {
            $data = $data->where('equipment_no', $equipment_no);
        }

        if ($request->get('filter_data') && $requisition_mst_no = $request->get('filter_data')["requisition_mst_no"]) {
            $data = $data->where('requisition_mst_no', $requisition_mst_no);
        }
        if ($request->get('filter_data') && isset($request->get('filter_data')["received_yn"]) && $received_yn = $request->get('filter_data')["received_yn"]) {
            $data = $data->where('received_yn', $received_yn);
        }

        if ($request->get('filter_data') && $from_date = $request->get('filter_data')['insert_start_date']) {
            $from_date = date('Y-m-d 00:00:00', strtotime($from_date));
            $data = $data->where('insert_date', '>=', $from_date);
        }

        if ($request->get('filter_data') && $to_date = $request->get('filter_data')['insert_end_date']) {
            $to_date = date('Y-m-d 23:59:59', strtotime($to_date));
            $data = $data->where('insert_date', '<=', $to_date);
        }
        //dd($data);
        return Datatables::of($data)
            // return datatables()->of($data->get())
            ->addIndexColumn()
            ->addColumn('requisition_mst_no', function ($data) {
                $data = json_decode(json_encode($data), true);
                $optionHtml = '<a href="' .route('admin.requisition-master.detail-view', ['id' => $data['requisition_mst_no']]). '" class="" target="_blank"><span>'.$data['requisition_mst_no'].'</span></a>';
                return $optionHtml;
            })
            ->addColumn('equipment_name', function ($data) {
                $data = json_decode(json_encode($data), true);
                $optionHtml = '<a href="' .route('admin.equipment-list.detail', ['id' => $data['equipment_no']]). '" class="" target="_blank"><span>'.$data['equipment_name'].'</span></a>';
                return $optionHtml;
            })
            ->addColumn('action', function ($data) {
                if($data->received_yn=='N'){
                    $optionHtml = '<a href="javascript:void(0)" class="show-receive-modal editButton">
                              <i class="bx bx-plus-medical cursor-pointer"></i></a>';

                    return $optionHtml;
                }else{
                    return '<span class="font-small-2 badge badge" style="text-shadow: 10px 10px 10px rgba(0,0,0,0.3);">Item Received</span>';
                }

            })
            ->escapeColumns([])
            ->make(true);
    }

    public function store(Request $request)
    {

        $postData = $request->post();
        $params = [];
        $purchase_date = isset($postData['purchase_date']) ? date('Y-m-d', strtotime($postData['purchase_date'])) : '';
        $warranty_expiry_date = isset($postData['warranty_expiry_date']) ? date('Y-m-d', strtotime($postData['warranty_expiry_date'])) : '';
        try {
            DB::beginTransaction();
            $equipment_add_no = null;
            if (!$equipment_add_no)
                $response = $this->bulk_update_stock_items($request);

          //  dd($response);
            if ((isset($response['o_status_code']) && $response['o_status_code'] == 1) || $equipment_add_no) {
                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");

                $params = [
                    'P_EQUIPMENT_ADD_NO' => $equipment_add_no,
                    'P_EQUIPMENT_ADD_ID' => $postData['equipment_add_id'],
                    'P_EQUIPMENT_ID' => $postData['equipment_id'],
                    'P_ITEM_ID' => $postData['item_id'],
                    'P_EQUIPMENT_NAME' => $postData['item_name'],
                    'P_EQUIPMENT_NAME_BN' => '',
                    'P_EQUIPMENT_DESCRIPTION' => $postData['equipment_description'],
                    'P_QUANTITY' => $postData['quantity'],
                    'P_VENDOR_NO' => $postData['vendor_no'],
                    'P_MANUFACTURER' => $postData['manufacturer'],
                    'P_MODEL_NO' => $postData['model_no'],
                    'P_SERIAL_NO' => $postData['serial_no'],
                    'P_PRICE' => $postData['appx_price'],
                    'P_PURCHASE_DATE' => $purchase_date,
                    'P_WARRANTY_EXPIRY_DATE' => $warranty_expiry_date,
                    'P_INSERT_BY' => auth()->id(),
                    'P_INSERT_DATE' => '',
                    'P_UPDATE_BY' => '',
                    'P_UPDATE_DATE' => '',
                    'o_status_code' => &$status_code,
                    'o_status_message' => &$status_message,
                ];
                DB::executeProcedure('TICKET.EQUIPMENT_ADD_CRUD', $params);

                if ($params['o_status_code'] != 1) {
                    DB::rollBack();
                    return $params;
                } else {
                    $dd = DB::table('equipment_requisition_dtl')
                        ->where('requisition_dtl_no', $postData['req_dtl_id'])
                        ->update(array('received_yn' => 'Y', 'received_qty' => $postData['quantity']));
                   // $this->bulk_update_stock_items($request);
                }

                DB::commit();
                if ($params['o_status_code'] == 1) {
                    Session::flash('success', $params['o_status_message']);
                    return redirect()->route('admin.purchase-order.index');
                }
                Session::flash('error', $params['o_status_message']);

                return redirect()->route('admin.purchase-order.index');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }

    private function bulk_update_stock_items($request){
        $postData = $request->all();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'p_reference_no' => null,
                'p_reference_id' => null,
                'p_item_id' => $postData['item_id'],
                'p_department_id' => 10,
                'p_store_id' => $postData['store_id'],
                'p_brand_id' => $postData['brand_id'],
                'p_variants_string' => $postData['variants'],
                'p_item_condition_id' => null,
                'p_req_qty' => $postData['quantity'],
                'p_is_employee' => null,
                'p_assign_employee_id' => null,
                'p_assign_department_id' =>  Auth::user()->employee->dpt_department_id,
                'p_buildings' => null,
                'p_room' => null,
                'p_insert_by' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            DB::executeProcedure("cims.bulk_update_stock_items", $params);
        }catch (\Exception $exception){
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $exception->getMessage()];
        }
        return $params;
    }

}
