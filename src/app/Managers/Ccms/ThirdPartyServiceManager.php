<?php


namespace App\Managers\Ccms;


use App\Entities\Security\User;
use App\Repositories\ThirdPartyServiceRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ThirdPartyServiceManager
{
  /** @var RequisitionMasterRepo  */
    protected $thirdPartyServiceRepo;


    /**
     * ThirdPartyServiceManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
   public function __construct(ThirdPartyServiceRepo $thirdPartyServiceRepo)
   {
       $this->thirdPartyServiceRepo = $thirdPartyServiceRepo;
   }

    /**
     * Get Service Ticket Tables based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getThirdPartyServiceTables(Request $request) {
       $data = $this->thirdPartyServiceRepo->findAll();
       // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
               // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
               $optionHtml = '<a href="'.route('third_party.index', ['id' => $data['third_party_service_id']]).'" class="" title="Edit Third Party"><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= '<a class="confirm-delete text-danger" href=""><i class="bx bx-trash cursor-pointer"></i></a>';
               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }

// ' .route('service_ticket.index', ['id' => $data['ticket_no']]). '


    /**
     * Get EquipmentList repo
     *
     * @return EquipmentListRepo
     */
    public function getThirdPartyServiceRepo() {
        return $this->thirdPartyServiceRepo;
    }

    public function sendToNotification($notification_to,$note,$module_id,$url=null,$priority=null){
        $notification_param = [
            "p_notification_to" => $notification_to,
            "p_insert_by" => Auth::id(),
            "p_note" => $note,
            "p_priority" => $priority,
            "p_module_id" => $module_id,
            "p_target_url" => $url
        ];
        DB::executeProcedure("cpa_security.cpa_general.notify_add", $notification_param);
    }

    public function getEmployeeUserInfoByEmpId($id){
        return User::where('user_name',$id)->first();
    }

}
