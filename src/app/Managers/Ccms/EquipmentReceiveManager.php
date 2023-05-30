<?php


namespace App\Managers\Ccms;


use App\Entities\Ccms\EquipmentReceive;
use App\Repositories\EquipmentReceiveRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EquipmentReceiveManager
{
  /** @var RequisitionMasterRepo  */
    protected $equipmentReceiveRepo;


    /**
     * EquipmentReceiveManager constructor.
     *
     * @param EquipmentReceiveRepo $equipmentReceiveRepo
     */
   public function __construct(EquipmentReceiveRepo $equipmentReceiveRepo)
   {
       $this->equipmentReceiveRepo = $equipmentReceiveRepo;
   }

    /**
     * Get Service Ticket Tables based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getEquipmentReceiveTables(Request $request) {


//               $data = EquipmentReceive::where('service_engineer_info_id', $se['service_engineer_info_id'])
               $data =  EquipmentReceive::
                    leftjoin('equipment_list', 'equipment_list.equipment_no', '=', 'service_equipment_receive.equipment_no')
//                   ->join('service_engineer_info', 'service_engineer_info.service_engineer_id', '=', 'service_equipment_receive.service_engineer_id')
//                   ->select('service_equipment_receive.*', 'equipment_list.equipment_name', 'service_engineer_info.service_engineer_name')
                   ->select(
                       'service_equipment_receive.receipt_no',
                       'service_equipment_receive.receipt_id',
                       'service_equipment_receive.ticket_no',
                       'service_equipment_receive.ticket_id',
                       'service_equipment_receive.received_note',
                       'service_equipment_receive.received_date',
                       'equipment_list.equipment_name');


       //$data = $this->equipmentReceiveRepo->findAll();

       if ($request->get('filter_data') && $equipment_no = $request->get('filter_data')["equipment_no"]){
           $data = $data->where('equipment_no',$equipment_no);
       }

       if ($request->get('filter_data') && $service_engineer_id = $request->get('filter_data')["service_engineer_id"]){
           $data = $data->where('service_engineer_id',$service_engineer_id);
       }

       if ($request->get('filter_data') && $received_start_date = $request->get('filter_data')['received_start_date']) {
           $received_start_date = date('Y-m-d 00:00:00', strtotime($received_start_date));
           $data = $data->where('received_date' ,'>=', $received_start_date);
       }

       if ($request->get('filter_data') && $received_end_date = $request->get('filter_data')['received_end_date']) {
           $received_end_date = date('Y-m-d 23:59:59', strtotime($received_end_date));
           $data = $data->where('received_date' ,'<=', $received_end_date);
       }
       //dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('received_note', function ($data) {
               if(!empty($data->received_note)){
                   $pieces = Str::limit($data->received_note, 100);
                   $show_line = $pieces.'<a href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="right"
                                            title="Go Detail View ->>"
                                            class="bd-success">....</a href="javascript:void(0)"
                                            >';
               }else{
                   $show_line = '';
               }
               return $show_line;
           })
           ->addColumn('received_date', function ($query) {
               return Carbon::parse($query->received_date)->format('d-m-Y');
           })
           ->editColumn('insert_date', function ($data) {
//                dd($data);

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
               $optionHtml = ''; // '<a data-toggle="tooltip" data-placement="right" title="Edit Equipment Receive" href="' .route('admin.equipment-receive.index', ['id' => $data['receipt_no']]). '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= '<a data-toggle="tooltip" data-placement="right" title="Detail View" href="' .route('admin.equipment-receive.detail', ['id' => $data['receipt_no']]). '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
               $optionHtml .= ' <a class="confirm-delete text-danger" href=""><i class="bx bx-trash cursor-pointer"></i></a>';
               if ($data['received_doc'])
                   $optionHtml .= ' <a title="Received Doc" href="' .route('download-receive-doc', ['id' => $data['receipt_no']]). '" target="_blank"><i class="bx bx-download cursor-pointer"></i></a>';

               if ($data['delivery_doc'])
                   $optionHtml .= ' <a title="Delivery Doc" href="' .route('download-delivery-doc', ['id' => $data['receipt_no']]). '" target="_blank"><i class="bx bx-download cursor-pointer"></i></a>';

               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get EquipmentList repo
     *
     * @return EquipmentListRepo
     */
    public function getEquipmentReceiveRepo() {
        return $this->equipmentReceiveRepo;
    }

}
