<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\GenSetupManager;
use Illuminate\Http\Request;

class ServiceStatusController extends Controller
{
    	/**
    	 * @param Request $request
    	 * @param GenSetupManager $genSetupManager
    	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
    	 */
        public function index(Request $request, GenSetupManager $genSetupManager)
        {
        	$data = $genSetupManager->getServiceStatusRepo()->findOne($request->get('id'));
            $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        	// dd($data);
            return view('ccms.setup.service_status', compact('data', 'gen_uniq_id'));
        }

        /**
         * ServiceEngineerSkill table data list
         *
         * @param Request $request
         * @param GenSetupManager $genSetupManager
         * @return mixed
         * @throws \Exception
         */
        public function list(Request $request, GenSetupManager $genSetupManager) {
            return $genSetupManager->getServiceStatusTables($request);
        }


        public function store($id = null, Request $request, ProcedureManager $procedureManager)
        {
            $result = $procedureManager->execute('GEN_SETUP.SERVICE_STATUS_CRUD', $request)->getParams();
            // dd($result);
            if ($result['o_status_code'] == 1) {
                Session::flash('success', $result['o_status_message']);
                return redirect()->route('service_status.index');
            }

            Session::flash('error', $result['o_status_message']);
            if ($id)
             return redirect()->route('service_status.index', ['id' => $id]);

             return redirect()->route('service_status.index');
        }
}
