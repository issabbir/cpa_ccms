<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Http\Controllers\Controller;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\ProcedureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class ContactPersonController extends Controller
{
    /**
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index($vendor_no, Request $request, GenSetupManager $genSetupManager) {
        $contactPerson  = $genSetupManager->getContactPersonRepo()->findOne($request->get('id'));
        $data = $genSetupManager->getVendorRepo()->findOne($vendor_no);
        $vendorTypes = $genSetupManager->getVendorRepo()->getVendorTypes();

        return view("ccms.setup.contact_person",compact('contactPerson', 'data', 'vendorTypes'));
    }

    /**
     * Vendor table data list
     *
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return mixed
     * @throws \Exception
     */
    public function list($vendor_no, Request $request, GenSetupManager $genSetupManager) {
        return $genSetupManager->getContactPersonTables($vendor_no,$request);
    }

    /**
     * @param integer $id
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     */
    public function store($vendor_no, Request $request, GenSetupManager $genSetupManager) {

        $result =  $genSetupManager->saveContactPerson($request->get('id'), $request);

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('contact-person.index', ['vendor_no' => $vendor_no]);
        }

        Session::flash('error', $result['o_status_message']);
        if ($id = $request->get('id'))
            return redirect()->route('contact-person.index', ['vendor_no' => $vendor_no, 'id' => $id]);

        return redirect()->route('contact-person.index', ['vendor_no' => $vendor_no]);
    }

    /**
     * @param $contactPersonId
     * @param GenSetupManager $genSetupManager
     */
    public function del($contactPersonId, GenSetupManager $genSetupManager) {
        $result = $genSetupManager->delContactPerson($contactPersonId);
    }
}
