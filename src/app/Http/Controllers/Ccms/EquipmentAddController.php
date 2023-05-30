<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAddManager;
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
        $getVendorList = $equipmentAddManager->getEquipmentAddRepo()->findAllVendorList();
        $gen_cat_id = DB::selectOne('select generate_category_id  as catagory_id from dual')->catagory_id;
        return view('ccms.equipment_add', compact('data', 'gen_cat_id', 'getEquipmentList', 'getVendorList'));
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
         // dd($request);
        $result = $procedureManager->execute('TICKET.EQUIPMENT_ADD_CRUD', $request)->getParams();
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('equipment_add.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('equipment_add.index', ['id' => $id]);

         return redirect()->route('equipment_add.index');
    }
}
