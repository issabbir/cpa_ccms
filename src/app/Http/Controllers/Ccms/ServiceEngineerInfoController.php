<?php

namespace App\Http\Controllers\Ccms;


use App\Http\Controllers\Controller;
use App\Entities\Ccms\ServiceEngineerSkillMapping;
use App\Entities\Ccms\VendorContactPerson;

use App\Managers\Ccms\ServiceEngineerInfoManager;
use App\Managers\Ccms\GenSetupManager;
use App\Managers\ProcedureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ServiceEngineerInfoController extends Controller
{
    /**
     * @param Request $request
     * @param ServiceEngineerInfoManager $serviceEngineerInfoManager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request,ServiceEngineerInfoManager $serviceEngineerInfoManager, GenSetupManager $genSetupManager) {
        $data  = $serviceEngineerInfoManager->getServiceEngineerInfoRepo()->findOne($request->get('id'));
        $gen_se_gen_id = DB::selectOne('select generate_service_engineer_id  as service_engineer_id from dual')->service_engineer_id;
        $engineerSkillList=$genSetupManager->getEngineerSkillRepo()->findAll();
        $service_engineer_info_id = $request->get('id');
        $skills = DB::select("
select SESM.ENGINEER_SKILL_MAPPING_ID, SESM.SERVICE_SKILL_ID from SERVICE_ENGINEER_SKILL_MAPPING SESM, SERVICE_ENGINEER_INFO SEI
where SEI.SERVICE_ENGINEER_ID = SESM.SERVICE_ENGINEER_ID
AND SEI.SERVICE_ENGINEER_INFO_ID = '$service_engineer_info_id'");

        $users = DB::select("select u.user_id, u.user_name from cpa_security.sec_user_roles ur
      inner join cpa_security.sec_role sr on (sr.role_id = ur.role_id)
      inner join cpa_security.sec_users u on (u.user_id = ur.user_id)
      where sr.role_key = 'CCMS_SERVICE_ENGINEER' and u.user_name not in (select user_name from service_engineer_info where user_name is not null)");
        $readonly = false;
        return view("ccms.service_engineer_info",compact('data','gen_se_gen_id','engineerSkillList','readonly','skills','users'));
    }

    /**
     * ServiceEngineerInfo table data list
     *
     * @param Request $request
     * @param ServiceEngineerInfoManager $serviceEngineerInfoManager
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, ServiceEngineerInfoManager $serviceEngineerInfoManager) {
        return $serviceEngineerInfoManager->getServiceEngineerInfoRepoTables($request);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param ServiceEngineerInfoManager $serviceEngineerInfoManager
     */
    public function store($id=null, Request $request,ProcedureManager $procedureManager) {
        //dd($request->all());
        DB::beginTransaction();
        if (!$id) {
            $result = $procedureManager->execute('SERVICE_ENGINEER.ins', $request)->getParams();
        }
        else {
            $result =  $procedureManager->execute('SERVICE_ENGINEER.upd', $request)->getParams();
            //dd($result);
        }

       if ($result['o_status_code'] == 1) {

           if ($request->get('service_skill_id')) {
               $sid = $result['o_service_engineer_id'];
               DB::delete('delete from SERVICE_ENGINEER_SKILL_MAPPING where SERVICE_ENGINEER_ID = ' . $result['o_service_engineer_id']);
               foreach ($request->get('service_skill_id') as $skill) {
                   $request->merge([
                       'service_engineer_id' => $sid,
                       'service_skill_id' => $skill,
                       'remarks' => 'Manually assigned',
                   ]);
                   $result = $procedureManager->execute('SERVICE_ENGINEER.ENGINEER_SKILL_MAP_CRUD', $request)->getParams();
                   if ($result['o_status_code'] != 1) {
                       DB::rollBack();
                       Session::flash('error', $result['o_status_message']);
                       if ($id)
                           return redirect()->route('service-engineer-info.index', ['id' => $id]);

                       return redirect()->route('service-engineer-info.index');
                   }
               }
           }

           if ($result['o_status_code'] == 1) {
               DB::commit();
               Session::flash('success', $result['o_status_message']);
               return redirect()->route('service-engineer-info.index');
           }
       }

        Session::flash('error', $result['o_status_message']);

       DB::rollBack();
        if ($id)
            return redirect()->route('service-engineer-info.index', ['id' => $id]);

        return redirect()->route('service-engineer-info.index');
    }

    /**
     * @param $serviceEngineerInfoId
     * @param ServiceEngineerInfoManager $serviceEngineerInfoManager
     */
    public function del($serviceEngineerInfoId, ServiceEngineerInfoManager $serviceEngineerInfoManager) {
        $result = $serviceEngineerInfoManager->delServiceEngineerInfo($serviceEngineerInfoId);
    }

    public function detailView(Request $request, ServiceEngineerInfoManager $serviceEngineerInfoManager)
    {
        $service_engineer_info_id = $request->get('id');

        $data  = $serviceEngineerInfoManager->getServiceEngineerInfoRepo()->findOne($service_engineer_info_id);
        $skills = DB::select("select SESM.ENGINEER_SKILL_MAPPING_ID, SESM.SERVICE_SKILL_ID, LSES.SERVICE_SKILL_NAME
from SERVICE_ENGINEER_SKILL_MAPPING SESM
LEFT JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = SESM.SERVICE_ENGINEER_ID)
LEFT JOIN L_SERVICE_ENGINEER_SKILL LSES ON (SESM.SERVICE_SKILL_ID= LSES.SERVICE_SKILL_ID)
WHERE SEI.SERVICE_ENGINEER_INFO_ID = :service_engineer_info_id", ['service_engineer_info_id' => $service_engineer_info_id]);

        return view('ccms.service_eng_info_dtl', compact('data','skills'));
    }
}
