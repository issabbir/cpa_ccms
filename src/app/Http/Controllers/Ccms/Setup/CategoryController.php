<?php

namespace App\Http\Controllers\Ccms\Setup;

use App\Entities\Ccms\Categories;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\ProcedureManager;
use App\Traits\Security\HasPermission;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CategoryController extends Controller
{

    use HasPermission;

    protected $category;

    protected $auth;
    private $genSetupManager;


    public function __construct(Categories $category, Guard $auth, GenSetupManager $genSetupManager)
    {
        $this->category = $category;
        $this->auth = $auth;
        $this->genSetupManager = $genSetupManager;
    }

    public function index(Request $request)
    {
        $categorydata = HelperClass::categoryMenu();
        return view('ccms.setup.category.index', ['data' => $this->category, 'categories' => $categorydata]);
    }

    public function edit($id)
    {
        $data = Categories::where('catagory_id',$id)->first();
        $categorydata = HelperClass::categoryMenu();
        return view('ccms.setup.category.index', ['data' => $data,  'categories' => $categorydata]);
    }

    public function destroy($id)
    {
       $request=new Request();
        $request['catagory_id']=$id;
       $procedureManager=new ProcedureManager();
       $result = $procedureManager->execute('GEN_SETUP.CAT_DEL', $request)
                ->getParams();
        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('category-index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id)
            return redirect()->route('category-index', ['id' => $id]);

        return redirect()->route('category-index');
    }

    public function post(Request $request, ProcedureManager $procedureManager)
    {
        if ($request->get('catagory_id')) {
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
            return redirect()->route('category-index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($request->get('category_id'))
         return redirect()->route('category-index', ['id' => $request->get('category_id')]);

         return redirect()->route('category-index');
    }


}
