<?php

namespace App\Http\Controllers\Ccms\Setup;
use App\Managers\ProcedureManager;
use App\Http\Controllers\Controller;
use App\Managers\Ccms\GenSetupManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class EngineerSkillController extends Controller
{

	/**
	 * @param Request $request
	 * @param GenSetupManager $genSetupManager
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
	 */
    public function index(Request $request, GenSetupManager $genSetupManager)
    {
    	$data = $genSetupManager->getEngineerSkillRepo()->findOne($request->get('id'));
        $readonly = false;
        return view('ccms.setup.service_engineer_skill', compact('data','readonly'));

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
        return $genSetupManager->getEngineerSkillTables($request);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ProcedureManager $procedureManager
     */
    public function store(Request $request, ProcedureManager $procedureManager)
    {
        $result =  $procedureManager->execute('GEN_SETUP.ENGINEER_SKILL_DTL_CRUD', $request)->getParams();

        if ($result['o_status_code'] == 1) {
            Session::flash('success', $result['o_status_message']);
            return redirect()->route('engineer_skill.index');
        }

        Session::flash('error', $result['o_status_message']);
        if ($id=$request->get('id'))
         return redirect()->route('engineer_skill.index', ['id' => $id]);

         return redirect()->route('engineer_skill.index');
    }
}
