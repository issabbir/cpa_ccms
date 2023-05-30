<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use App\Entities\Ccms\VendorList;
use App\Entities\Ccms\VendorContactPerson;
use App\Managers\Ccms\ThirdPartyServiceManager;
use App\Managers\ProcedureManager;
use App\Managers\Ccms\RequisitionMasterManager;
use App\Managers\Ccms\GenSetupManager;
use App\Repositories\RequisitionDetailsRepo;
use App\Repositories\RequisitionMasterRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class RequisitionMasterController extends Controller
{
    /** @var RequisitionMasterRepo  */
    protected $requisitionMasterRepo;
    protected $requisitionRepo;


    /**
     * RequisitionDetailsManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
    public function __construct(RequisitionMasterRepo $requisitionMasterRepo,RequisitionDetailsRepo $requisitionRepo)
    {
        $this->requisitionMasterRepo = $requisitionMasterRepo;
        $this->requisitionRepo = $requisitionRepo;
    }

    /**
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index( Request $request,RequisitionMasterManager $requisitionMasterManager,GenSetupManager $genSetupManager, ThirdPartyServiceManager $thirdPartyServiceManager) {
        $data  = $requisitionMasterManager->getRequisitionMasterRepo()->findOne($request->get('id'));
        $gen_req_id = DB::selectOne('select generate_requisation_id as requisition_id from dual')->requisition_id;
        $getTicketNo =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getTicketNo();
        $getEquipmentID =  $thirdPartyServiceManager->getThirdPartyServiceRepo()->getEquipmentID();
        $employeeList= [];

        $readonly = false;
        return view("ccms.requisition_master",compact('data', 'gen_req_id','employeeList','readonly','getTicketNo','getEquipmentID'));
    }


    /**
     * Requisition Master  table data list
     *
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, RequisitionMasterManager $requisitionMasterManager) {
        return $requisitionMasterManager->getRequisitionMasterTables($request);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param RequisitionMasterManager $requisitionMasterManager
     */
    public function store($id=null , Request $request,ProcedureManager $procedureManager ) {
        //$result =  $requisitionMasterManager->saveRequisitionMaster($id, $request);
        if (!$id){
            $result =  $procedureManager->execute('REQUISITION.requisition_ins', $request)->getParams();
        }
        else{
            $result =  $procedureManager->execute('REQUISITION.requisition_upd', $request)->getParams();
        }

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('requisition-master.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('requisition-details.index', ['id' => $id]);

        return redirect()->route('requisition-master.index');
    }

    /**
     * @param $requisitionMstNo
     * @param RequisitionMasterManager $requisitionMasterManager
     */
    public function del($requisitionMstNo, RequisitionMasterManager $requisitionMasterManager) {
        $result = $requisitionMasterManager->delRequisition($requisitionMstNo);
    }
}
