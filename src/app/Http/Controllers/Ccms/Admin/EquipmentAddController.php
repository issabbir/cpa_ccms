<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Entities\FAS\Supplier;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAddManager;
use App\Managers\Ccms\EquipmentAssigneManager;
use App\Managers\Ccms\EquipmentListManager;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentAddController extends Controller
{
    /**
     * @param Request $request
     * @param EquipmentAddManager $equipmentAddManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, EquipmentAddManager $equipmentAddManager)
    {
        $data = $equipmentAddManager->getEquipmentAddRepo()->findOne($request->get('id'));
        $getEquipmentList = $equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentList();
//        $getVendorList = $equipmentAddManager->getEquipmentAddRepo()->findAllVendorList();
        $getVendorList = Supplier::all();
        $gen_equpment_add_id = DB::selectOne('select generate_equipment_add_id  as equipment_add_id from dual')->equipment_add_id;
        $getManufacturerList = DB::select('select DISTINCT manufacturer from equipment_add');
        return view('ccms.admin.manage_equipment.equipment_add', compact('data', 'gen_equpment_add_id', 'getEquipmentList', 'getVendorList','getManufacturerList'));
    }

    public function detail(Request $request, EquipmentListManager $equipmentListManager, EquipmentAddManager $equipmentAddManager){
        $getEquipmentAddDtl = $equipmentAddManager->getEquipmentAddRepo()->findOne($request->get('id'));
        return view('ccms.admin.manage_equipment.equipment_add_dtl', compact('getEquipmentAddDtl'));
    }

    /**
     * Category table data list
     *
     * @param Request $request
     * @param EquipmentAddManager $equipmentAddManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, EquipmentAddManager $equipmentAddManager) {
        return $equipmentAddManager->getEquipmentAddRepoTables($request);
    }

    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        $result = $procedureManager->execute('TICKET.EQUIPMENT_ADD_CRUD', $request)->getParams();
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('admin.equipment-add.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('admin.equipment-add.index', ['id' => $id]);

         return redirect()->route('admin.equipment-add.index');
    }
    public function getInventoryDetails(Request $request){
        //dd($request->all());
        $sql  = "SELECT cims.get_stock_purchase_info(:p_ITEM_ID,:p_BRAND_ID,:P_VARIANTS_STRING) from dual";

        $param = [
            'p_ITEM_ID'=>$request->get('item_id'),
            'p_BRAND_ID'=>$request->get('brand_id') != 'null' ?  $request->get('brand_id') : null,
            'P_VARIANTS_STRING'=>$request->get('variants') ? $request->get('variants') :null,
        ];
       // dd($param);
        $data = DB::selectOne($sql,$param);

        return $response = ["status" => true, "data" => $data];

    }
}
