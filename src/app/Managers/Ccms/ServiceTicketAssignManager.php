<?php


namespace App\Managers\Ccms;


use App\Repositories\ServiceTicketAssignRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\Pmis\Employee\Statuses;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceTicketAssignManager
{
  /** @var RequisitionMasterRepo  */
    protected $serviceTicketAssignRepo;


    /**
     * ServiceTicketAssignManager constructor.
     *
     * @param ServiceTicketAssignRepo $serviceTicketAssignRepo
     */
   public function __construct(ServiceTicketAssignRepo $serviceTicketAssignRepo)
   {
       $this->serviceTicketAssignRepo = $serviceTicketAssignRepo;
   }

    /**
     * Get Service Ticket Tables based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getServiceTicketAssignTables(Request $request) {
       $data = $this->serviceTicketAssignRepo->findAll();
       // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
               // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
               $optionHtml = '<a data-ticket_no="'.''.$data->ticket_no.''.'" href="'.route('ticket_assign.index', ['id' => $data['assignment_no']]).'" class="" title="Edit Third Party"><i class="bx bx-edit cursor-pointer"></i></a>';
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
    public function getServiceTicketAssignRepo() {
        return $this->serviceTicketAssignRepo;
    }

}
