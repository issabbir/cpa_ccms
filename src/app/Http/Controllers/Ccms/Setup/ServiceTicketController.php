<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Http\Controllers\Controller;
use App\Managers\Ccms\ServiceTicketManager;
use Illuminate\Http\Request;

class ServiceTicketController extends Controller
{
    	/**
    	 * @param Request $request
    	 * @param ServiceTicketManager $genSetupManager
    	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
    	 */
        public function index(Request $request, ServiceTicketManager $serviceTicketManager) 
        {
        	$data = $serviceTicketManager->getServiceTicketRepo()->findOne($request->get('id'));
        	// dd($data);
            return view('ccms.service_ticket', compact('data'));
        }

        /**
         * Service Ticket table data list
         *
         * @param Request $request
         * @param GenSetupManager $genSetupManager
         * @return mixed
         * @throws \Exception
         */
        public function list(Request $request, GenSetupManager $genSetupManager) {
            return $genSetupManager->getServiceTicketTables($request);
        }

}
