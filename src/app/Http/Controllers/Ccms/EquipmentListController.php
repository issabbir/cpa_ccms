<?php

namespace App\Http\Controllers\Ccms;


use App\Http\Controllers\Controller;
use App\Entities\Ccms\VendorList;
use App\Entities\Ccms\VendorContactPerson;

use App\Managers\Ccms\EquipmentListManager;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\ProcedureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class EquipmentListController extends Controller
{
    /**
     * @param Request $request
     * @param EquipmentListManager $equipmentListManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, EquipmentListManager $equipmentListManager, GenSetupManager $genSetupManager) {
        $data  = $equipmentListManager->getEquipmentListRepo()->findOne($request->get('id'));
        $gen_equ_id = DB::selectOne('select generate_equipment_id  as equipment_id from dual')->equipment_id;
        $vendorTypes = $genSetupManager->getVendorRepo()->findAll();
        $CategoriesTypes=$equipmentListManager->getEquipmentListRepo()->getCategoriesTypes();
        $SubCategoriesTypes=$equipmentListManager->getEquipmentListRepo()->getSubCategoriesTypes();

        $readonly = false;
        return view("ccms.equipment_list",compact('gen_equ_id','data', 'vendorTypes', 'CategoriesTypes','SubCategoriesTypes' ,'readonly'));
    }

    /**
     * EquipmentLis table data list
     *
     * @param Request $request
     * @param EquipmentListManager $equipmentListManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, EquipmentListManager $equipmentListManager) {
        return $equipmentListManager->getEquipmentListTables($request);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ProcedureManager $procedureManager
     */
    public function store($id = null, Request $request,ProcedureManager $procedureManager) {
        if (!$id)
            $result =  $procedureManager->execute('EQUIPMENT.ins', $request)->getParams();
        else
            $result =  $procedureManager->execute('EQUIPMENT.upd', $request)->getParams();

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('equipment-list.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('equipment-list.index', ['id' => $id]);

        return redirect()->route('equipment-list.index');
    }

    /**
     * @param $equipmentNo
     * @param EquipmentListManager $equipmentListManager
     */
    public function del($equipmentNo, EquipmentListManager $equipmentListManager) {
        $result = $equipmentListManager->delEquipment($equipmentNo);
    }




}
