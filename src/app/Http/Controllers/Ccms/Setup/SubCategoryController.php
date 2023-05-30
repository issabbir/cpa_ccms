<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Entities\Ccms\SubCategories;
use App\Http\Controllers\Controller;
use App\Entities\Ccms\Categories;
use App\Managers\ProcedureManager;
use App\Managers\Ccms\GenSetupManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    //
    public function index(Request $request, GenSetupManager $genSetupManager)
    {
        $subCategories  = $genSetupManager->getSubCatagoryRepo()->findOne($request->get('id'));
        $gen_cat_id = DB::selectOne('select generate_category_id  as catagory_id from dual')->catagory_id;
        $data = $genSetupManager->getCategoryRepo()->findOne($request->get('id'));
    	// dd($subCategories);
    	// dd($data);
        return view('ccms.setup.equipment_sub_categories', compact('data', 'subCategories', 'gen_cat_id'));
    }

    /**
     * Vendor table data list
     *
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return mixed
     * @throws \Exception
     */
    public function list($catagory_no, Request $request, GenSetupManager $genSetupManager) {
        return $genSetupManager->getSubCatagoryTables($catagory_no, $request);
    }

    public function store($catagory_no, Request $request, ProcedureManager $procedureManager)
    {
        if ($id = $request->get('id')) {
            $result = $procedureManager->execute('GEN_SETUP.SUB_CAT_UPD', $request)
                ->getParams();
        }
        else {
            $result = $procedureManager->execute('GEN_SETUP.SUB_CAT_INS', $request)
                ->getParams();
        }
        // dd($result);
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('sub_category.index', ['catagory_no' => $catagory_no]);
        }

        Session::flash('error', $result['o_status_message']);
        if ($id = $request->get('id'))
         return redirect()->route('sub_category.index', ['catagory_no' => $catagory_no, 'id' => $id]);

         return redirect()->route('sub_category.index', ['catagory_no' => $catagory_no]);
    }

    public function ajaxlist($category_no, GenSetupManager $genSetupManager) {
        return $genSetupManager->getSubCatagoryRepo()->findSubCatagories($category_no);
    }
}
