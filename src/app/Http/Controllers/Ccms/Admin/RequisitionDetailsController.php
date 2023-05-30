<?php

namespace App\Http\Controllers\Ccms\Admin;

use App\Http\Controllers\Controller;
use App\Entities\Ccms\VendorList;
use App\Entities\Ccms\VendorContactPerson;

use App\Managers\Ccms\RequisitionDetailsManager;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\Ccms\RequisitionMasterManager;
use App\Managers\ProcedureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class RequisitionDetailsController extends Controller
{
    /**
     * @param Request $request
     * @param RequisitionDetailsManager $requisitionManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index( $requisition_mst_no,Request $request, RequisitionMasterManager  $requisitionMasterManager ) {
        $data  = $requisitionMasterManager->getRequisitionRepo()->findOne($request->get('id'));
        $requisitionMaster = $requisitionMasterManager->getRequisitionMasterRepo()->findOne($requisition_mst_no);
        $readonly = false;
        $item_sql = "select CIMS.get_item_list(:p_department_id,:p_item_name) from dual";
        $items = DB::select($item_sql, ['p_department_id' => 10, 'p_item_name' => null]);//computer center=10
        return view("ccms.admin.manage_requisition.requisition_details",compact('data', 'requisitionMaster','readonly','items'));
    }

    /**
     * Vendor table data list
     *
     * @param Request $request
     * @param RequisitionMasterManager  $requisitionMasterManager
     * @return mixed
     * @throws \Exception
     */
    public function list($requisition_mst_no, Request $request, RequisitionMasterManager  $requisitionMasterManager) {
        return $requisitionMasterManager->getRequisitionDetailsTables($requisition_mst_no,$request);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ProcedureManager $procedureManager
     */
    public function store($requisition_mst_no, Request $request, RequisitionMasterManager  $requisitionMasterManager) {
        $result =  $requisitionMasterManager->saveRequisition($request,$request->get('id'));

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('admin.requisition-details.index',['requisition_mst_no' => $requisition_mst_no]);
        }

        Session::flash('error', $result['o_status_message']);
        if ($id=$request->get('id'))
            return redirect()->route('admin.requisition-details.index',['requisition_mst_no' => $requisition_mst_no, 'id' => $id]);

        return redirect()->route('admin.requisition-details.index',['requisition_mst_no' => $requisition_mst_no]);
    }

    /**
     * @param $requisitionDtlNo
     * @param RequisitionDetailsManager $requisitionManager
     */
    public function del($requisitionDtlNo, RequisitionMasterManager  $requisitionMasterManager) {
        $result = $requisitionMasterManager->delRequisition($requisitionDtlNo);
    }
}
