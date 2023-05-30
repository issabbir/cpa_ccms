<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use App\Managers\Ccms\EquipmentAssigneManager;
use App\Managers\ProcedureManager;
use App\Managers\Ccms\EquipmentAddManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentAssigneController extends Controller
{
    	/**
    	 * @param Request $request
    	 * @param EquipmentAssigneManager $equipmentAssigneManager
    	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
    	 */
        public function index(Request $request, EquipmentAssigneManager $equipmentAssigneManager, EquipmentAddManager $equipmentAddManager)
        {
        	$data = $equipmentAssigneManager->getEquipmentAssigneRepo()->findOne($request->get('id'));
            $departments = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllDepartment();
            $sections = $equipmentAssigneManager->getEquipmentAssigneRepo()->findAllSection();
            $getEquipmentList = $equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentList();
            $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        	// dd($section);
            return view('ccms.equipment_assigne', compact('data', 'gen_uniq_id', 'getEquipmentList', 'departments', 'sections'));
        }

        /**
         * ServiceEngineerSkill table data list
         *
         * @param Request $request
         * @param EquipmentAssigneManager $equipmentAssigneManager
         * @return mixed
         * @throws \Exception
         */
        public function list(Request $request, EquipmentAssigneManager $equipmentAssigneManager) {
            return $equipmentAssigneManager->getEquipmentAssigneRepoTables($request);
        }




        public function store($id = null, Request $request, ProcedureManager $procedureManager)
        {
            $result = $procedureManager->execute('TICKET.EQUIPMENT_ASSIGN_CRUD', $request)->getParams();
            // dd($result);
            if ($result['o_status_code'] == 1) {
                Session::flash('success', $result['o_status_message']);
                return redirect()->route('equipment_assigne.index');
            }

            Session::flash('error', $result['o_status_message']);
            if ($id)
             return redirect()->route('equipment_assigne.index', ['id' => $id]);

             return redirect()->route('equipment_assigne.index');
        }
}
