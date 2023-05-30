<?php

namespace App\Http\Controllers\Ccms\Admin;


use App\Entities\Ccms\EquipmentList;
use App\Entities\Ccms\EquipmentStatus;
use App\Entities\Cctv\Registration;
use App\Entities\CIMS\ItemInventoryDetails;
use App\Entities\CIMS\LStore;
use App\Entities\CIMS\LWarehouse;
use App\Entities\FAS\Supplier;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;

use App\Managers\Ccms\EquipmentAddManager;
use App\Managers\Ccms\EquipmentAssigneManager;
use App\Managers\Ccms\EquipmentListManager;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\Ccms\ServiceTicketManager;
use App\Managers\ProcedureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class EquipmentListController extends Controller
{
    /**
     * @param Request $request
     * @param EquipmentListManager $equipmentListManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, ServiceTicketManager $serviceTicketManager, EquipmentAssigneManager $equipmentAssigneManager, EquipmentListManager $equipmentListManager, GenSetupManager $genSetupManager, EquipmentAddManager $equipmentAddManager)
    {
        $data = $equipmentListManager->getEquipmentListRepo()->findOne($request->get('id'));
        $gen_equ_id = DB::selectOne('select generate_equipment_id  as equipment_id from dual')->equipment_id;
//        $vendorTypes = $genSetupManager->getVendorRepo()->findAll();
        $vendorTypes = Supplier::all();
        $getEquipmentStatus = EquipmentStatus::all();
        $getWarehouse = LWarehouse::where('active_yn', 'Y')->get();
        $CategoriesTypes = $equipmentListManager->getEquipmentListRepo()->getCategoriesTypes();
        $equipmentList = $equipmentListManager->getEquipmentListRepo()->findAllWithDistinctEquipmentName();
        $allEquipmentList = $equipmentListManager->getEquipmentListRepo()->findAllEquipmentList();
        $equipmentListWithoutVariants = $equipmentListManager->getEquipmentListRepo()->findEquipmentNameWithoutVariants();
//        dd($equipmentList);
        $categories = HelperClass::categoryMenu();
        $SubCategoriesTypes = $equipmentListManager->getEquipmentListRepo()->getSubCategoriesTypes();
        $getEquipmentList = $equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentList();
        $departments = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllDepartment();
        $sections = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllSection();
        $readonly = false;
        $sql = "select CIMS.get_item_list(:p_department_id,:p_item_name) from dual";
        $locationList = DB::select("select loc.location_id, loc.working_location from pmis.l_location loc");
        $items = DB::select($sql, ['p_department_id' => 10, 'p_item_name' => null]);
        return view("ccms.admin.manage_equipment.equipment_list", compact('gen_equ_id', 'data', 'vendorTypes', 'SubCategoriesTypes', 'readonly', 'getEquipmentList', 'departments','sections','locationList', 'getEquipmentStatus', 'categories', 'items', 'getWarehouse', 'equipmentList', 'equipmentListWithoutVariants', 'allEquipmentList'));
    }

    public function detail(Request $request, ServiceTicketManager $serviceTicketManager, EquipmentListManager $equipmentListManager, EquipmentAssigneManager $equipmentAssigneManager, EquipmentAddManager $equipmentAddManager)
    {
        $data = $equipmentAssigneManager->getEquipmentAssigneRepo()->findOne($request->get('id'));
        $getEquipmentList = $equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentList();
        $getDatas = $equipmentListManager->getEquipmentListRepo()->getData($request->get('id'));
        $sections = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllSection();
        $getEquipmentStatus = EquipmentStatus::all();
        $departments = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllDepartment();
        $getEquipmentDtl = $equipmentListManager->getEquipmentListRepo()->findOne($request->get('id'));
        $equipment_no = $request->get('id');
        $requisitionData = DB::select("select erm.requisition_id,rs.status_name,erm.ticket_yn,erm.ticket_no,erm.equipment_no,erm.requisition_note,erm.requisition_date,emp.emp_name as requisition_for, el.equipment_name, erm.requisition_mst_no
from equipment_requisition_mst erm, equipment_list el, pmis.employee emp, l_requisition_status rs
where erm.equipment_no = :equipment_no
and erm.equipment_no = el.equipment_no
and erm.requisition_status_id = rs.requisition_status_id
and erm.requisition_for = emp.emp_id", ['equipment_no' => $equipment_no]);

        $thirdPartyData = DB::select("select tps.*, vl.VENDOR_NAME, el.EQUIPMENT_NAME from THIRD_PARTY_SERVICE TPS, VENDOR_LIST VL, EQUIPMENT_LIST EL
where tps.EQUIPMENT_NO = :equipment_no
and tps.approved_yn = :approved_yn
and tps.vendor_no = vl.vendor_no(+)
and tps.EQUIPMENT_NO = el.EQUIPMENT_NO", ['equipment_no' => $equipment_no, 'approved_yn' => 'Y']);

        $equipAssignData = DB::select("select ea.*,DEP.DEPARTMENT_NAME, EMP.EMP_NAME, EMP.EMP_CODE,LOC.WORKING_LOCATION, EL.EQUIPMENT_STATUS_ID, ES.STATUS_NAME, DESIG.DESIGNATION FROM EQUIPMENT_ASSIGN EA
LEFT JOIN PMIS.L_DEPARTMENT DEP ON (DEP.DEPARTMENT_ID = EA.DEPARTMENT_ID)
LEFT JOIN PMIS.EMPLOYEE EMP ON (EMP.EMP_ID = EA.EMP_ID)
LEFT JOIN PMIS.L_DESIGNATION DESIG ON (EMP.DESIGNATION_ID = DESIG.DESIGNATION_ID)
LEFT JOIN EQUIPMENT_LIST EL ON (EL.EQUIPMENT_NO = EA.EQUIPMENT_NO)
LEFT JOIN L_EQUIPMENT_STATUS ES ON (ES.EQUIPMENT_STATUS_ID = EL.EQUIPMENT_STATUS_ID)
LEFT JOIN PMIS.L_LOCATION LOC ON (LOC.LOCATION_ID = EA.BUILDING_NO)
WHERE EL.EQUIPMENT_NO = :equipment_no
ORDER BY ASSIGN_DATE desc", ['equipment_no' => $equipment_no]);
        $serviceTicketData = DB::select("select st.*, stt.ticket_type_name, stp.remarks, emp.emp_name, ss.status_name, dep.department_name, emp.emp_code from service_ticket st
left join l_service_ticket_type stt on (st.ticket_type_no = stt.ticket_type_no)
left join pmis.l_department dep on (dep.department_id = st.department_id)
left join l_service_ticket_priority stp on (stp.ticket_priority_no = st.ticket_priority_no)
left join pmis.employee emp on (emp.emp_id = st.emp_id)
left join l_service_status ss on (ss.status_no = st.service_status_no)
where st.equipment_no = :equipment_no", ['equipment_no' => $equipment_no]);
        $equipmentItemData = DB::select("select ea.*, vl.vendor_name from equipment_add ea
left join equipment_list el on (el.equipment_id = ea.equipment_id)
left join vendor_list vl on (vl.vendor_no = ea.vendor_no)
where el.equipment_no = :equipment_no", ['equipment_no' => $equipment_no]);

        $equipmentItemDataResult = json_decode(json_encode($equipmentItemData), true);
        $total_equipment_item = array_sum(array_column($equipmentItemDataResult, 'price'));

        $thirdPartyDataResult = json_decode(json_encode($thirdPartyData), true);
        $total_third_party = array_sum(array_column($thirdPartyDataResult, 'service_charge'));

        $locationList = DB::select("select loc.location_id, loc.working_location from pmis.l_location loc");
        return view('ccms.admin.manage_equipment.equipment_dtl', compact('getEquipmentDtl', 'data', 'getEquipmentList',
            'departments', 'sections', 'requisitionData', 'thirdPartyData', 'getDatas', 'equipAssignData', 'locationList', 'getEquipmentStatus',
            'serviceTicketData', 'equipmentItemData', 'total_equipment_item', 'total_third_party'));
    }

    /**
     * EquipmentLis table data list
     *
     * @param Request $request
     * @param EquipmentListManager $equipmentListManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, EquipmentListManager $equipmentListManager)
    {
        return $equipmentListManager->getEquipmentListTables($request);
    }

    public function downloadFile(Request $request, $id)
    {
        $docData = EquipmentList::find($id);//dd($docData);

        if ($docData) {
            if ($content = $docData->invoice) {
                $arr = explode(',', $content);
                $base64 = $arr[1];
                $arr2 = explode("/", $arr[0]);
                $typeA = explode(";", $arr2[1]);
                $file = str_replace("data:", "", $arr2[0]);
                $type = $typeA[0];
                return response()->make(base64_decode($base64), 200, [
                    'Content-Type' => "$file/$type",
                    'Content-Disposition' => 'attachment; filename="Invoice_' . $id . ".$type"
                ]);
            }
        }
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ProcedureManager $procedureManager
     */
    /*public function store($id = null, Request $request,ProcedureManager $procedureManager)
    {
       //dd($request->all());
        DB::beginTransaction();
        if (!$id){
            $response = $this->bulk_update_stock_items($request);
            //dd($response);
            if ((isset($response['o_status_code']) && $response['o_status_code'] == 1)) {
                $result = $procedureManager->execute('EQUIPMENT.ins', $request)->getParams();
                if ($result['o_status_code'] != 1){
                    DB::rollBack();
                }
                DB::commit();
            }else{
                DB::rollBack();
                Session::flash('error', $response['o_status_message']);
                return redirect()->route('admin.equipment-list.index');
            }
        }else{
            $result =  $procedureManager->execute('EQUIPMENT.upd', $request)->getParams();
            DB::commit();
        }

        if ($result['o_status_code'] == 1)
        {
            DB::commit();
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('admin.equipment-list.index');
        }

        DB::rollBack();
        Session::flash('error', $result['o_status_message']);

        if ($id)
            return redirect()->route('admin.equipment-list.index', ['id' => $id]);

        return redirect()->route('admin.equipment-list.index');
    }*/


    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        $result = '';
        //dd($request->all());
        DB::beginTransaction();
        if (!$id) {
            /*$sqlStock = "SELECT IID.ID, IID.ITEM_INVENTORY_ID, IID.STORE_ID, IID.DEPARTMENT_ID, IID.ITEM_ID, IID.BRAND_ID, IID.UNIT_ID, IID.UNIT_PRICE, IID.SKU_CODE,
IID.WARRANTY_YN, IID.WARRANTY_EXPIRY_DATE, IID.ITEM_NAME, IID.BRAND_NAME, IID.VARIANT_NAME, IID.STORE_NAME, IID.ITEM_SERIAL_NO, IID.SUPPLIER_ID,
IID.ITEM_DESCRIPTION, IID.ITEM_CONDITION_ID, IID.LOT_NUMBER, IID.MODEL_NO, IID.VARIANTS_STRING VARIANTS, IID.ROOM_ID, IID.WAREHOUSE_NAME, IID.ROOM_NO,
IID.WAREHOUSE_ID, IID.SKU_CODE, REQMST.PURCHASE_ORDER_DATE PURCHASE_DATE, IID.VARIANTS_STRING
FROM CIMS.ITEM_INVENTORY_DETAILS IID, CIMS.L_ITEM IT, CIMS.PURCHASE_REQ_MST REQMST, CIMS.PURCHASE_RCV_MST RCVMST
WHERE IID.STORE_ID = :STORE_ID
AND IID.DEPARTMENT_ID = :DEPARTMENT_ID
AND IID.ITEM_ID = :ITEM_ID
AND IID.VARIANTS_STRING = :VARIANTS_STRING
AND IID.BRAND_ID = :BRAND_ID
AND IT.ITEM_ID = IID.ITEM_ID
AND IID.PURCHASE_RCV_MST_ID = RCVMST.PURCHASE_RCV_MST_ID
AND RCVMST.PURCHASE_REQ_MST_ID = REQMST.PURCHASE_REQ_MST_ID";*/

            $sqlStock = "
SELECT IID.ID,
       IID.ITEM_INVENTORY_ID,
       IID.STORE_ID,
       IID.DEPARTMENT_ID,
       IID.ITEM_ID,
       IID.BRAND_ID,
       IID.UNIT_ID,
       IID.UNIT_PRICE,
       IID.SKU_CODE,
       IID.WARRANTY_YN,
       IID.WARRANTY_EXPIRY_DATE,
       IID.ITEM_NAME,
       IID.BRAND_NAME,
       IID.VARIANT_NAME,
       IID.STORE_NAME,
       IID.ITEM_SERIAL_NO,
       IID.SUPPLIER_ID,
       IID.ITEM_DESCRIPTION,
       IID.ITEM_CONDITION_ID,
       IID.LOT_NUMBER,
       IID.MODEL_NO,
       IID.VARIANTS_STRING
           VARIANTS,
       IID.ROOM_ID,
       IID.WAREHOUSE_NAME,
       IID.ROOM_NO,
       IID.WAREHOUSE_ID,
       IID.SKU_CODE,
       CASE
           WHEN IID.CASH_PURCHASE_ID IS NOT NULL
           THEN
               (SELECT CASH_PURCHASE_MST.PURCHASE_REQ_DATE
                  FROM CIMS.CASH_PURCHASE_MST
                 WHERE CASH_PURCHASE_MST.CASH_PURCHASE_ID =
                       IID.CASH_PURCHASE_ID)
           ELSE
               (SELECT PURCHASE_REQ_MST.PURCHASE_ORDER_DATE
                  FROM CIMS.PURCHASE_REQ_MST
                       INNER JOIN CIMS.PURCHASE_RCV_MST
                           ON (PURCHASE_RCV_MST.PURCHASE_REQ_MST_ID =
                               PURCHASE_REQ_MST.PURCHASE_REQ_MST_ID)
                 WHERE PURCHASE_RCV_MST.PURCHASE_RCV_MST_ID =
                       IID.PURCHASE_RCV_MST_ID)
       END
           PURCHASE_DATE,
       IID.VARIANTS_STRING
  FROM CIMS.ITEM_INVENTORY_DETAILS IID, CIMS.L_ITEM IT
 WHERE     IID.STORE_ID = :STORE_ID
       AND IID.DEPARTMENT_ID = :DEPARTMENT_ID
       AND IID.ITEM_ID = :ITEM_ID
       AND NVL (IID.VARIANTS_STRING, NULL) =
           CASE WHEN :VARIANTS_STRING IS NULL THEN NULL ELSE IID.VARIANTS_STRING END
       AND NVL (IID.BRAND_ID, 0) =
           CASE WHEN :BRAND_ID IS NULL THEN 0 ELSE IID.BRAND_ID END
       AND NVL (IID.WAREHOUSE_ID, 0) =
           CASE WHEN :WAREHOUSE_ID IS NULL THEN 0 ELSE IID.WAREHOUSE_ID END
       AND IT.ITEM_ID = IID.ITEM_ID
       AND IID.STOCK_IN_YN='Y'
       ORDER BY IID.INSERT_DATE ASC";

           // echo  $sqlStock;exit;

            $datas = DB::select($sqlStock, [
                'ITEM_ID' => $request->get('item_id'),
                'BRAND_ID' => $request->get('brand_id'),
                'DEPARTMENT_ID' => $request->get('department_id'),
                'VARIANTS_STRING' => $request->get('variants'),
                'WAREHOUSE_ID' => $request->get('warehouse_id'),
                'STORE_ID' => $request->get('store_id'),
            ]);//Log::Info($datas);
            //dd($request->all());
//dd($datas);

                foreach ($datas as $key=>$data) {
                    //$response = $this->update_stock_items($data);
                  //  dd($data);
                   // DB::beginTransaction();
                    $assign_store = LStore::where('department_id',10)->first();
                    $update = ItemInventoryDetails::where('id', $data->id)
                        ->update(['STOCK_IN_YN' => 'N','STOCK_OUT_YN' => 'Y',
                            'STOCK_OUT_DATE' => date('Y-m-d'),
                            'QTY_STOCK_OUT' => 1,'ASSIGN_DEPARTMENT_ID' => 10,
                            'ASSIGN_TO_STORE_ID' => $assign_store->store_id,'UPDATE_BY' => auth()->id()]);
                   // echo $update;
                    //DB::commit();
                    //exit;

                    //$response = $this->bulk_update_stock_items($data);
                    //Log::Info($update);
                    //if ((isset($response['o_status_code']) && $response['o_status_code'] == 1)) {
                    if ((isset($update) && $update == 1)) {
                        $m_date = null;
                        if(isset($data->purchase_date)){
                            $p_date = date('Y-m-d', strtotime($data->purchase_date));
                        }else{
                            $p_date = null;
                        }

                        if(isset($data->warranty_expiry_date)){
                            $warranty = date('Y-m-d', strtotime($data->warranty_expiry_date));
                        }else{
                            $warranty = date('Y-m-d', strtotime($data->purchase_date.' + 5 years'));
                        }

                        if($data->variants_string!=null){
                            $item_name = $data->item_name.' ('.$data->variants_string.')';
                        }else{
                            $item_name = $data->item_name;
                        }

//                        $request->request->add(['equipment_id' => 'E'.time().$data->item_serial_no]);
                        $request->request->add(['equipment_id' => 'E'.time().rand(100,1000)]);
                        $request->request->add(['equipment_name' => $item_name]);
                        $request->request->add(['stock_quantity' => $request->get('qty')]);
                        $request->request->add(['stock_warranty_yn' => '']);
                        $request->request->add(['equipment_name_bn' => '']);
                        $request->request->add(['catagory_no' => '']);
                        $request->request->add(['vendor_no' => $data->supplier_id]);
                        $request->request->add(['manufacturer' => '']);
                        $request->request->add(['model_no' => $data->variants_string]);
                        $request->request->add(['serial_no' => $data->item_serial_no]);
                        $request->request->add(['price' => $data->unit_price]);
                        $request->request->add(['purchase_date' => $p_date]);
                        $request->request->add(['last_maintenance_date' => $m_date]);
                        $request->request->add(['warranty_expiry_date' => $warranty]);
                        $request->request->add(['total_maintenance_cost' => '']);
                        $request->request->add(['no_of_maintenance' => '']);
                        $request->request->add(['equipment_description' => $data->item_description]);
                        $request->request->add(['assign_to' => '']);
                        $request->request->add(['inventory_details_id' => $data->id]);
                        $request->request->add(['inventory_sl_no' => $data->sku_code]);

                        $result = $procedureManager->execute('EQUIPMENT.ins', $request)->getParams();
                        //Log::Info($result);
                   // dd($result);
                    if ($result['o_status_code'] != 1) {
                        //DB::rollBack();
                    }

                }else {
                        DB::rollBack();
//                Session::flash('error', $response['o_status_message']);
//                return redirect()->route('admin.equipment-list.index');
                        return ['status'=>false, 'message' => $result['o_status_message']];
                    }
                    DB::commit();
            }

            return ['status'=>true, 'message' => 'Successfully Inserted','data'=>$result];
        } else {
            $result = $procedureManager->execute('EQUIPMENT.upd', $request)->getParams();
            DB::commit();
        }

        if ($result['o_status_code'] == 1) {
            DB::commit();
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('admin.equipment-list.index');
        }

        DB::rollBack();
        Session::flash('error', $result['o_status_message']);

        if ($id)
            return redirect()->route('admin.equipment-list.index', ['id' => $id]);

        return redirect()->route('admin.equipment-list.index');
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ProcedureManager $procedureManager
     */
    public function updateStatus(Request $request)
    {
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'P_EQUIPMENT_STATUS_ID' => $request->get('equipment_status'),
            'P_EQUIPMENT_NO' => $request->get('equipment_no'),
            'P_INSERT_BY' => auth()->id(),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        DB::executeProcedure('EQUIPMENT.equipment_status_change', $params);

        if ($params['o_status_code'] == 1) {
            Session::flash('success', $params['o_status_message']);
        } else {
            Session::flash('error', $params['o_status_message']);
        }
        return redirect()->to(url('/admin/equipment-detail?id=' . $request->get("equipment_no")));
    }

    /**
     * @param $equipmentNo
     * @param EquipmentListManager $equipmentListManager
     */
    public function del($equipmentNo, EquipmentListManager $equipmentListManager)
    {
        $result = $equipmentListManager->delEquipment($equipmentNo);
    }

    public function storeEquipmentAssign($id = null, Request $request, ProcedureManager $procedureManager)
    {
        if ($request->get("person_wise_use_yn") == 'Y') {
            $dept_id = $request->get("emp_department_id");
            $sec_id = $request->get("emp_section_id");
            $out_emp_name = '';
            $out_emp_dept = '';
            $out_emp_desig = '';
            $out_emp_section = '';
        } else if($request->get("person_wise_use_yn") == 'N') {
            $out_emp_name = '';
            $out_emp_dept = '';
            $out_emp_desig = '';
            $out_emp_section = '';
            $dept_id = $request->get("department_id");
            $sec_id = $request->get("dpt_section_id");
        } else if($request->get("person_wise_use_yn") == 'O') {
            $out_emp_name = strtoupper($request->get("emp_name_outside"));
            $out_emp_dept = $request->get("emp_dept_outside");
            $out_emp_desig = $request->get("emp_desig_outside");
            $out_emp_section = $request->get("emp_section_outside");
            $dept_id = '';
            $sec_id = '';
        }
        $eqip_assign_date = $request->get("eqip_assign_date");
        if(isset($eqip_assign_date)){
            $assign_date = date('Y-m-d', strtotime($eqip_assign_date));
        }else{
            $assign_date = null;
        }
        $equipment_assign_id = null;
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");
        $params = [
            "P_EQUIPMENT_ASSIGN_ID" => [
                'value' => &$equipment_assign_id,
                'type' => \PDO::PARAM_INPUT_OUTPUT,
                'length' => 255
            ],
            "P_EQUIPMENT_NO" => $request->get("equipment_no"),
            "P_PERSON_WISE_USE_YN" => $request->get("person_wise_use_yn"),
            "P_EMP_ID" => ($request->get("emp_id")) ? $request->get("emp_id") : '',
            "P_DEPARTMENT_ID" => $dept_id,
            "P_SECTION_ID" => $sec_id,
            "P_BUILDING_NO" => $request->get("building_no"),
            "P_ROOM_NO" => $request->get("room_no"),
            "P_EQIP_ASSIGN_DATE" => $assign_date,
            "P_OUTSIDE_EMP_NAME" => $out_emp_name ? $out_emp_name : '',
            "P_OUTSIDE_EMP_DEPT" => $out_emp_dept ? $out_emp_dept : '',
            "P_OUTSIDE_EMP_DESIG" => $out_emp_desig ? $out_emp_desig : '',
            "P_OUTSIDE_EMP_SECTION" => $out_emp_section ? $out_emp_section : '',
            "P_INSERT_BY" => auth()->id(),
            "P_UPDATE_BY" => '',//auth()->id(),
            "o_status_code" => &$status_code,
            "o_status_message" => &$status_message
        ];
        $result = DB::executeProcedure("EQUIPMENT.EQUIPMENT_ASSIGN_CRUD", $params);
        $flag = $request->get("flag");
        if (isset($flag) && $flag == 'Y'){
            DB::beginTransaction();
            DB::table('CIMS.ITEM_INVENTORY_DETAILS')
                ->where('id', $request->get('inventory_details_id'))
                ->update([
                    'assign_employee_id' => ($request->get("emp_id")) ? $request->get("emp_id") : '',
                    'assign_department_id'       => $dept_id,
                    'buildings'       => $request->get("building_no"),
                    'room'       => $request->get("room_no"),
                ]);
            DB::commit();
        }
        if ($params['o_status_code'] == 1) {
            Session::flash('success', $params['o_status_message']);
            return redirect()->route('admin.equipment-list.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('admin.equipment-list.index', ['id' => $id]);

        return redirect()->to(url('/admin/equipment-detail?id=' . $request->get("equipment_no")));
    }

    public function inventory(Request $request)
    {
        try {
//             $data = VwItemStock::where('item_id',$request->get('item_id'))->get();
            // dd($data);
            $view = view('ccms.admin.manage_equipment.inventory_list', [
                'item_id' => $request->get('item_id')
            ])->render();

            return $response = ["status" => true, "html" => $view];
        } catch (\Exception $e) {
            //Log::info($e->getMessage());
            DB::rollBack();
            $response = ["status" => false, "status_code" => 99, "message" => 'Please try again later.'];
        }
        // dd($response);
        return $response;
    }

    public function inventoryView(Request $request, EquipmentListManager $equipmentListManager, GenSetupManager $genSetupManager, EquipmentAddManager $equipmentAddManager)
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

            $sql = "SELECT cims.get_stock_purchase_info(:p_ITEM_ID,:p_BRAND_ID,:P_VARIANTS_STRING) from dual";

            $data = DB::selectOne($sql, [
                'p_ITEM_ID' => $request->get('item_id'),
                'p_BRAND_ID' => $request->get('brand_id'),
                'P_VARIANTS_STRING' => $request->get('variants'),
            ]);
            // dd($data);
            $vendorTypes = $genSetupManager->getVendorRepo()->findAll();
            $categories = HelperClass::categoryMenu();
            $getWarehouse = LWarehouse::where('active_yn', 'Y')->get();
            $gen_equ_id = DB::selectOne('select generate_equipment_id  as equipment_id from dual')->equipment_id;
//            $departments = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllDepartment();
            $view = view('ccms.admin.manage_equipment.view_data', [
                'stock' => $data,
                'stockView' => $stockView,
                'data' => $equipmentListManager->getEquipmentListRepo()->findOne($request->get('id')),
                'vendorTypes' => $vendorTypes,
                'categories' => $categories,
                'gen_equ_id' => $gen_equ_id,
                'getWarehouse' => $getWarehouse,
            ])->render();

            return $response = ["status" => true, "html" => $view];
        } catch (\Exception $e) {
            dd($e->getMessage());
            //Log::info($e->getMessage());
            DB::rollBack();
            $response = ["status" => false, "status_code" => 99, "message" => 'Please try again later.'];
        }
        // dd($response);
        return $response;
    }

    public function update_stock_items($postData)
    {
        $postData = (array)$postData;
        try {
            DB::beginTransaction();
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'p_dtl_id' => $postData['id'],
                'p_assign_department_id' => 10,
                'p_insert_by' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];//dd($params);

            DB::executeProcedure("cims.update_stock_items", $params);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $exception->getMessage()];
        }
        return $params;
    }

    public function bulk_update_stock_items($postData)
    {
//        $postData = $request->post();
        $postData = (array)$postData;//dd($postData);
        $emp_id = Auth::user()->employee->emp_id;
        $department_id = Auth::user()->employee->dpt_department_id;
        try {
            DB::beginTransaction();
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                'p_reference_no' => null,
                'p_reference_id' => null,
                'p_item_id' => $postData['item_id'],
                'p_department_id' => $postData['department_id'],
                'p_store_id' => $postData['store_id'],
                'p_brand_id' => $postData['brand_id'],
                'p_variants_string' => $postData['variants'],
                'p_item_condition_id' => null,
                'p_req_qty' => 1,
                'p_is_employee' => null,
                'p_assign_employee_id' => null,
                'p_assign_department_id' => 10,
                'p_buildings' => null,
                'p_room' => null,
                'p_warehouse_id' => $postData['warehouse_id'],
                'p_insert_by' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];//dd($params);

            DB::executeProcedure("cims.bulk_update_stock_items", $params);
            DB::commit();
            // dd($params);
        } catch (\Exception $exception) {
            // dd($exception->getMessage());
            //DB::rollBack();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $exception->getMessage()];
        }
        return $params;
    }

    public function removeEquipment(Request $request)
    {
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");

        $params = [
            'p_EQUIPMENT_NO' => $request->get('equipment_no'),
            'o_status_code' => &$status_code,
            'o_status_message' => &$status_message,
        ];
        DB::executeProcedure('EQUIPMENT.del', $params);
        return $params['o_status_code'] . '+' . $params['o_status_message'];
    }

    public function employee(Request $request, $empId)
    {
        return $this->findEmployeeInformation($empId);
    }

    public function employees(Request $request)
    {
        $searchTerm = $request->get('term');
        $employees = $this->findEmployeeCodesBy($searchTerm);

        return $employees;
    }

    public function findEmployeeCodesBy($searchTerm)
    {
        return Employee::whereIn('emp_status_id', [Statuses::ON_ROLE, Statuses::DEPUTATION])
        ->where(function ($query) use ($searchTerm) {
            $query->where(DB::raw('LOWER(employee.emp_name)'), 'like', strtolower('%' . trim($searchTerm) . '%'))
                ->orWhere('employee.emp_code', 'like', '' . trim($searchTerm) . '%');
        }
        )->orderBy('emp_code', 'ASC')->limit(10)->get(['emp_id', 'emp_code', 'emp_name']);

        /*return Employee::where(
            [
                ['emp_code', 'like', '' . $searchTerm . '%'],
                ['emp_status_id', '=', Statuses::ON_ROLE],
            ]
        )->orderBy('emp_code', 'ASC')->limit(10)->get(['emp_id', 'emp_code', 'emp_name']);*/
    }

    public function findEmployeeInformation($employeeId)
    {
        $query = <<<QUERY
SELECT
       emp.emp_id emp_id,
       emp.emp_code emp_code,
       emp.emp_name emp_name,
       emp.emp_name_bng emp_name_bng,
       emp.nid_no,
       emp.emp_emergency_contact_mobile,
       des.DESIGNATION designation,
       des.DESIGNATION_ID,
       dep.DEPARTMENT_NAME department,
       dep.department_id,
       sec.DPT_SECTION section,
       sec.DPT_SECTION_ID,
       (SELECT EMP_CONTACT_INFO FROM PMIS.EMP_CONTACTS WHERE EMP_CONTACT_TYPE_ID =1 AND EMP_ID = emp.EMP_ID AND ROWNUM <= 1)  emp_email,
       (SELECT EMP_CONTACT_INFO FROM PMIS.EMP_CONTACTS WHERE EMP_CONTACT_TYPE_ID =2 AND EMP_ID = emp.EMP_ID AND ROWNUM <= 1)  emp_mbl,
       (SELECT ADDRESS_LINE_1 FROM PMIS.EMP_ADDRESSES WHERE ADDRESS_TYPE_ID =2 AND EMP_ID = emp.EMP_ID AND ROWNUM <= 1)  emp_addr
FROM
     pmis.EMPLOYEE emp
     LEFT JOIN pmis.L_DESIGNATION des
       on emp.DESIGNATION_ID = des.DESIGNATION_ID
     LEFT JOIN pmis.L_DEPARTMENT dep
        on emp.DPT_DEPARTMENT_ID = dep.DEPARTMENT_ID
     LEFT JOIN pmis.L_DPT_SECTION sec
        on emp.SECTION_ID = sec.DPT_SECTION_ID
WHERE
  emp.emp_id = :emp_id
  AND emp.EMP_STATUS_ID in (1,13)--  :emp_status_id
QUERY;

        $employee = DB::selectOne($query, ['emp_id' => $employeeId]);
//        , 'emp_status_id' => Statuses::ON_ROLE
        if ($employee) {
            $jsonEncodedEmployee = json_encode($employee);
            $employeeArray = json_decode($jsonEncodedEmployee, true);

            return $employeeArray;
        }

        return [];
    }

}
