<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Managers\Ccms\GenSetupManager;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketPriorityController extends Controller
{
    	/**
    	 * @param Request $request
    	 * @param GenSetupManager $genSetupManager
    	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
    	 */
        public function index(Request $request, GenSetupManager $genSetupManager) 
        {
        	$data = $genSetupManager->getTicketPriorityRepo()->findOne($request->get('id'));
            $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        	// dd($data);
            return view('ccms.setup.service_ticket_priority', compact('data', 'gen_uniq_id'));
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
            return $genSetupManager->getTicketPriorityTables($request);
        }



        public function store($id = null, Request $request, ProcedureManager $procedureManager)
        {
            $result = $procedureManager->execute('GEN_SETUP.SERVICE_TICKET_PRIORITY_CRUD', $request)->getParams();
            // if ($id) {
            // }
            // else {
            //     $result = $procedureManager->execute('TICK_PRIOR.TICK_PRIOR_INS', $request)->getParams();
            // }
            // dd($result);
            if ($result['o_status_code'] == 1) {
                Session::flash('success', $result['o_status_message']);
                return redirect()->route('ticket_priority.index');
            }

            Session::flash('error', $result['o_status_message']);
            if ($id)
             return redirect()->route('ticket_priority.index', ['id' => $id]);

             return redirect()->route('ticket_priority.index');
        }
}
