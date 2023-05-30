<?php
namespace App\Managers\Ccms;

use App\Contracts\Ccms\EquipmentListContract;
use App\Entities\Ccms\EquipmentList;
use Illuminate\Support\Facades\DB;



class EcLisManager implements EquipmentListContract
{
    public function ecLiCud($action_type=null, $request = [], $id=0)
    {

//        try {
//            $status_code = sprintf("%4000s", "");
//            $status_message = sprintf("%4000s", "");
//            $params = [
//                "P_ACTION_TYPE" => $action_type,
//                "P_ID"  => [ "value" => &$id, "type" => \PDO::PARAM_INPUT_OUTPUT, "length" => 255 ],
//                "P_VESSEL_ID" => $request->get("vessel_id"),
//                "P_JETTY_ID" => $request->get("jetty_id"),
//                "P_CURGO_ID" => $request->get("cargo_id"),
//                "P_ARIVAL_AT" =>  date("Y-m-d", strtotime($request->get("arrival_at"))),
//                "P_BERTHING_AT" => ($request->get("berthing_at") != "") ? date("Y-m-d", strtotime($request->get("berthing_at"))) : "",
//                "P_SHIFTING_AT" =>  ($request->get("shifting_at") != "") ? date("Y-m-d", strtotime($request->get("shifting_at"))) : "",
//                "P_LEAVING_AT" => date("Y-m-d", strtotime($request->get("leaving_at"))),
//                "P_IMPORT_DISCH" => $request->get("import_disch"),
//                "P_B_ON_BOARD" => $request->get("b_on_board"),
//                "P_EXP_LEFTED" => $request->get("exp_lefted"),
//                "P_T_ON_BOARD" => $request->get("t_on_board"),
//                "P_LOCAL_AGENT" => $request->get("local_agent"),
//                "P_STATUS"   => ($action_type == 'I')?'P':"P",
//                "P_PILOTAGE_TYPE_ID" => $request->get("pilotage_type_id"),
//                "P_PILOTAGE_TIME" =>  date("Y-m-d h:i",strtotime(date("Y-m-d").' '.$request->get("pilotage_time"))),
//                "P_PILOT_ID" => ($request->get("pilot_id") == '') ? '' : $request->get("pilot_id"),
//                "P_PILOTAGE_SCHEDULE_START" => ($request->get("pilotage_schedule_start") == '') ? '' : $request->get("pilotage_schedule_start"),
//                "P_PILOTAGE_SCHEDULE_END" => ($request->get("pilotage_schedule_end") == '') ? '' : $request->get("pilotage_schedule_end"),
//                "P_NOTIFICATION_TYPE" => ($request->get("notification_type") == '') ? '' : $request->get("notification_type"),
//                "P_USER_ID" => auth()->id(),
//                "O_STATUS_CODE" => &$status_code,
//                "O_STATUS_MESSAGE" => &$status_message
//            ];
//
//
//            DB::executeProcedure("MDA.MDA_CORE_PROCE.BERTHING_SCHEDULE_CUD", $params);
//
//            $response = [
//                "status" => ($params['O_STATUS_CODE'] ==='1')?true:false,
//                "status_code" =>  $params['O_STATUS_CODE'],
//                "data" => $params,
//                "status_message" => $params['O_STATUS_MESSAGE']
//            ];
//        } catch (\Exception $e) {
//            $response = ["status" => false, "status_code" => 99, "status_message" => $e->getMessage()];
//        }
//
////        dd($response);
//        return $response;
    }
    public function ecLiDatatable()
    {
       return EquipmentList::get();;

  }


}





