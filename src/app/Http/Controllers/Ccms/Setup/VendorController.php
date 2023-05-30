<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Http\Controllers\Controller;
use App\Entities\Ccms\VendorList;
use App\Entities\Ccms\VendorContactPerson;
use App\Managers\Ccms\GenSetupManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    /**
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, GenSetupManager $genSetupManager) {
        $data  = $genSetupManager->getVendorRepo()->findOne($request->get('id'));
        $gen_vn_id = DB::selectOne('select generate_vendor_id  as vendor_id from dual')->vendor_id;
        $vendorTypes = $genSetupManager->getVendorRepo()->getVendorTypes();
        $readonly = false;
        return view("ccms.setup.vendors",compact('data', 'vendorTypes', 'gen_vn_id', 'readonly'));
    }

    /**
     * Vendor table data list
     *
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, GenSetupManager $genSetupManager) {
        return $genSetupManager->getVendorTables($request);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     */
    public function store($id = null, Request $request, GenSetupManager $genSetupManager) {
        $result =  $genSetupManager->saveVendor($id, $request);

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('vendors.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('vendors.index', ['id' => $id]);

        return redirect()->route('vendors.index');
    }

    /**
     * @param $vendorNo
     * @param GenSetupManager $genSetupManager
     */
    public function del($vendorNo, GenSetupManager $genSetupManager) {
        $result = $genSetupManager->delVendor($vendorNo);
    }
}
