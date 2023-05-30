<?php


namespace App\Managers\Ccms;

use App\Repositories\EquipmentAddRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EquipmentAddManager
{
  /** @var EquipmentAddRepo  */
    protected $equipmentAddRepo;


    /**
     * EquipmentAddManager constructor.
     *
     * @param EquipmentAddRepo $equipmentAddRepo
     */
   public function __construct(EquipmentAddRepo $equipmentAddRepo)
   {
       $this->equipmentAddRepo = $equipmentAddRepo;
   }

    /**
     * Get Service Ticket Tables based on datatable
     *
     * @return mixed
     * @throws Exception
     */
   public function getEquipmentAddRepoTables($request) {
       $data = $this->equipmentAddRepo->findAll();

       if ($request->get('filter_data') && $equipment_id = $request->get('filter_data')["equipment_id"]){
           $data = $data->where('equipment_id',$equipment_id);
       }

       if ($request->get('filter_data') && $vendor_no = $request->get('filter_data')["vendor_no"]){
           $data = $data->where('vendor_no',$vendor_no);
       }

       if ($request->get('filter_data') && $manufacturer = $request->get('filter_data')["manufacturer"]){
           $data = $data->where('manufacturer',$manufacturer);
       }

       if ($request->get('filter_data') && $purchase_start_date = $request->get('filter_data')['purchase_start_date']) {
           $purchase_start_date = date('Y-m-d 00:00:00', strtotime($purchase_start_date));
           $data = $data->where('purchase_date' ,'>=', $purchase_start_date);
       }

       if ($request->get('filter_data') && $purchase_end_date = $request->get('filter_data')['purchase_end_date']) {
           $purchase_end_date = date('Y-m-d 23:59:59', strtotime($purchase_end_date));
           $data = $data->where('purchase_date' ,'<=', $purchase_end_date);
       }

       if ($request->get('filter_data') && $warranty_expiry_date_start = $request->get('filter_data')['warranty_expiry_date_start']) {
           $warranty_expiry_date_start = date('Y-m-d 00:00:00', strtotime($warranty_expiry_date_start));
           $data = $data->where('warranty_expiry_date' ,'>=', $warranty_expiry_date_start);
       }

       if ($request->get('filter_data') && $warranty_expiry_date_end = $request->get('filter_data')['warranty_expiry_date_end']) {
           $warranty_expiry_date_end = date('Y-m-d 23:59:59', strtotime($warranty_expiry_date_end));
           $data = $data->where('warranty_expiry_date' ,'<=', $warranty_expiry_date_end);
       }
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('purchase_date', function ($query) {
               return Carbon::parse($query->purchase_date)->format('d-m-Y');
           })
           ->addColumn('warranty_expiry_date', function ($query) {
               return Carbon::parse($query->warranty_expiry_date)->format('d-m-Y');
           })
           ->addColumn('vendor_name', function ($query) {
               return isset($query->vendor) ? $query->vendor->vendor_name : '';
           })
           ->editColumn('insert_date', function ($data) {
               // dd($data);

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })

           ->addColumn('equipment_id', function ($data) {
               if($data->equipment_id){
                   $status = DB::selectOne('select EQUIPMENT_NAME from EQUIPMENT_LIST where equipment_id =:equipment_id', ['equipment_id' => $data->equipment_id]);
                   return $status->equipment_name;
               }else{
                   return '';
               }
           })
           ->addColumn('action', function ($data) {
               $optionHtml = '<a href="' .route('admin.equipment-add.index', ['id' => $data['equipment_add_no']]). '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= '<a href="' .route('admin.equipment-add.detail', ['id' => $data['equipment_add_no']]). '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
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
     * @return EquipmentAddRepo
     */
    public function getEquipmentAddRepo() {
        return $this->equipmentAddRepo;
    }

}
