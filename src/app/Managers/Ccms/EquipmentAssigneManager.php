<?php


namespace App\Managers\Ccms;


use App\Repositories\EquipmentAssigneRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EquipmentAssigneManager
{
  /** @var EquipmentAssigneRepo  */
    protected $equipmentAssigneRepo;


    /**
     * EquipmentAssigneManager constructor.
     *
     * @param EquipmentAssigneRepo $requisitionMasterRepo
     */
   public function __construct(EquipmentAssigneRepo $equipmentAssigneRepo)
   {
       $this->equipmentAssigneRepo = $equipmentAssigneRepo;
   }

    /**
     * Get Service Ticket Tables based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getEquipmentAssigneRepoTables(Request $request) {
       $data = $this->equipmentAssigneRepo->findAll();
       //dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('assign_date', function ($query) {
               return Carbon::parse($query->assign_date)->format('d-m-Y');
           })
           ->editColumn('insert_date', function ($data) {
               // dd($data);

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
               $optionHtml = '<a href="' .route('equipment_assigne.index', ['id' => $data['equipment_assign_id']]). '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= '<a class="confirm-delete text-danger" href=""><i class="bx bx-trash cursor-pointer"></i></a>';
// ' .route('service_ticket.ticket_dtl', ['id' => $data['ticket_no']]). '

               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get EquipmentList repo
     *
     * @return EquipmentAssigneRepo
     */
    public function getEquipmentAssigneRepo() {
        return $this->equipmentAssigneRepo;
    }

}
