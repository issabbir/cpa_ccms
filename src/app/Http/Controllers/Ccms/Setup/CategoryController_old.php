<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Http\Controllers\Controller;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\ProcedureManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CategoryControllerOld extends Controller
{
    /**
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, GenSetupManager $genSetupManager)
    {
        $data = $genSetupManager->getCategoryRepo()->findOne($request->get('id'));
        $gen_cat_id = DB::selectOne('select generate_category_id  as catagory_id from dual')->catagory_id;
//        return view('ccms.setup.equipment_categories', compact('data', 'gen_cat_id'));
        return view('ccms.setup.category.index', compact('data', 'gen_cat_id'));
    }

    /**
     * Category table data list
     *
     * @param Request $request
     * @param GenSetupManager $genSetupManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, GenSetupManager $genSetupManager) {
        return $genSetupManager->getCategoryTables($request);
    }

    public function store($id = null, Request $request, ProcedureManager $procedureManager)
    {
        if ($id) {
            $result = $procedureManager->execute('GEN_SETUP.CAT_UPD', $request)
                ->getParams();
        }
        else {
            $result = $procedureManager->execute('GEN_SETUP.CAT_INS', $request)
                ->getParams();
        }
         // dd($result);
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('category.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
         return redirect()->route('category.index', ['id' => $id]);

         return redirect()->route('category.index');
    }
}
