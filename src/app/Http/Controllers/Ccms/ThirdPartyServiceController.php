<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\Session;
use App\Managers\Ccms\ThirdPartyServiceManager;
use Illuminate\Http\Request;

class ThirdPartyServiceController extends Controller
{
    public function index(Request $request, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
    	$data = $thirdPartyServiceManager->getThirdPartyServiceRepo()->findOne($request->get('id'));
        $gen_uniq_id = DB::selectOne('select gen_unique_id  as unique_id from dual')->unique_id;
        $getEquipmentID =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
        $getTicketNo =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getTicketNo();
        $getVendorNo =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getVendorNo();
        // dd($getVendorNo);
        return view('ccms.third_party_service', compact('data', 'gen_uniq_id', 'getEquipmentID', 'getTicketNo', 'getVendorNo'));
    }

    /**
     * Service Ticket table data list
     *
     * @param Request $request
     * @param ThirdPartyServiceManager $thirdPartyServiceManager
     * @return mixed
     * @throws \Exception
     */

    public function list(Request $request, ThirdPartyServiceManager $thirdPartyServiceManager)
    {
    	return $thirdPartyServiceManager->getThirdPartyServiceTables($request);
    }


    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {

        $result = $procedureManager->execute('TICKET.THIRD_PARTY_SERVICE_CRUD', $request)->getParams();
       // dd($result);
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('third_party.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('third_party.index', ['id' => $id]);

         return redirect()->route('third_party.index');
    }
}
