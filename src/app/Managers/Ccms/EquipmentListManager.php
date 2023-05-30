<?php


namespace App\Managers\Ccms;

use App\Entities\Ccms\EquipmentList;
use App\Repositories\EquipmentListRepo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EquipmentListManager
{
  /** @var EquipmentListRepo  */

  protected $equipmentListRepo;

    /**
     * EquipmentListManager constructor.
     *
     * @param EquipmentListRepo $equipmentListRepo
     */

   public function __construct(EquipmentListRepo $equipmentListRepo)
   {
       $this->equipmentListRepo = $equipmentListRepo;
   }

    /**
     * Get vendor table based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getEquipmentListTables($request) {
       $data = $this->equipmentListRepo->getEquipment();
       $filters = $request->get('filter_data');
       if ($request->get('filter_data') && isset($filters['warranty_expired_yn'])) {
           $sysdate = date('Y-m-d',time());
           if($filters['warranty_expired_yn'] == 'Y'){
               $data = $data->where('warranty_expiry_date', '<', $sysdate);
           } else {
               $data = $data->where('warranty_expiry_date', '>=', $sysdate);
           }
       }

       if ($request->get('filter_data') && isset($filters['equipment_status_id']) && $equipment_status_id = $request->get('filter_data')["equipment_status_id"]){
           $data = $data->where('equipment_status_id',$equipment_status_id);
       }

       if ($request->get('filter_data') && isset($filters['serial_no']) && $serial_no = $request->get('filter_data')["serial_no"]){
           $data = $data->where('serial_no',$serial_no);
       }

       if ($request->get('filter_data') && isset($filters['equipment_assign']) && $equipment_assign = $request->get('filter_data')["equipment_assign"]){
           if($equipment_assign=='Y'){
               $data = $data->whereNotNull('equipment_assign_id');
           }else{
               $data = $data->whereNull('equipment_assign_id');
           }
       }

       if ($request->get('filter_data') && $emp_id = isset($request->get('filter_data')["assign_emp_id"])?$request->get('filter_data')["assign_emp_id"]:''){
           $data = $data->where('assign_emp_id',$emp_id);
       }

       if ($request->get('filter_data') && $item_id = isset($request->get('filter_data')["item_id"])?$request->get('filter_data')["item_id"]:''){
           $data = $data->where('item_id',$item_id);
       }

       if ($request->get('filter_data') && $equipment_name = isset($request->get('filter_data')["equipment_name"])?$request->get('filter_data')["equipment_name"]:''){
           $data = $data->where('equipment_name',$equipment_name);
       }

       if ($request->get('filter_data') && $department_id = $request->get('filter_data')["department_id_show"]){
           $data = $data->where('assign_dpt_id',$department_id);
       }

       if ($request->get('filter_data') && isset($filters['person_use_yn_filter']) && $person_wise_use_yn = $request->get('filter_data')["person_use_yn_filter"]){
           $data = $data->where('person_use_yn',$person_wise_use_yn);
       }

       if (isset($filters['outsider_name']) && $outsider_name = strtoupper($filters["outsider_name"])) {
           $data = $data->where(DB::raw('upper(outsider_name)') , "like" , "%" .$outsider_name. "%");
       }

       if ($request->get('filter_data') && $vendor_no = $request->get('filter_data')["vendor_no"])
           $data = $data->where('vendor_no',$vendor_no);

       /*if ($request->get('filter_data') && $purchase_start_date = $request->get('filter_data')['purchase_start_date']) {
           $purchase_start_date = date('Y-m-d 00:00:00', strtotime($purchase_start_date));
           $data = $data->where('purchase_date' ,'>=', $purchase_start_date);
       }

       if ($request->get('filter_data') && $purchase_end_date = $request->get('filter_data')['purchase_end_date']) {
           $purchase_end_date = date('Y-m-d 23:59:59', strtotime($purchase_end_date));
           $data = $data->where('purchase_date' ,'<=', $purchase_end_date);
       }*/

       if ($request->get('filter_data') && $assign_start_date = $request->get('filter_data')['assign_start_date']) {
           $assign_start_date = date('Y-m-d 00:00:00', strtotime($assign_start_date));
           $data = $data->where('eqip_assign_date' ,'>=', $assign_start_date);
//           dd($request->get('filter_data')['assign_start_date']);
       }

       if ($request->get('filter_data') && $assign_end_date = $request->get('filter_data')['assign_end_date']) {
           $assign_end_date = date('Y-m-d 23:59:59', strtotime($assign_end_date));
           $data = $data->where('eqip_assign_date' ,'<=', $assign_end_date);
       }

       return Datatables::of($data->get())
           ->addIndexColumn()
           ->addColumn('purchase_date', function ($data) {
               if($data->purchase_date!=null){
                   return Carbon::parse($data->purchase_date)->format('d-m-Y');
               }else{
                   return '--';
               }

           })
           ->addColumn('eqip_assign_date', function ($data) {
               if($data->eqip_assign_date!=null){
                   return Carbon::parse($data->eqip_assign_date)->format('d-m-Y');
               }else{
                   return '--';
               }

           })
           ->addColumn('warranty_expiry_date', function ($data) {
               if($data->warranty_expiry_date!=null){
                   return Carbon::parse($data->warranty_expiry_date)->format('d-m-Y');
               }else{
                   return '--';
               }
           })
           ->addColumn('vendor_name', function ($data) {
               return isset($data->vendor) ? $data->vendor->vendor_name : '';
           })
           ->addColumn('assign_to', function ($data) {
               if($data->person_use_yn=='Y'){
                   $employee = DB::selectOne('select emp_name, emp_code from pmis.employee where emp_id =:emp_id', ['emp_id' => $data->assign_emp_id]);
                   return isset($employee->emp_name) ? $employee->emp_name. " (".$employee->emp_code. ")" : '';
               }
               else if ($data->person_use_yn=='N') {
                   $dpt = DB::selectOne('select department_name from pmis.L_DEPARTMENT where department_id =:dpt_id', ['dpt_id' => $data->assign_dpt_id]);
                   return isset($dpt->department_name) ? $dpt->department_name : '';
               }
               else if ($data->person_use_yn=='O') {
                   return $data->outsider_name;
               }
               else {
                   //return "Unassigned";
                   $optionHtml = '<a href="javascript:void(0)" class="show-receive-modal editButton" data-equipmentNo="'.$data->equipment_no.'">Unassigned</a>';
                   return $optionHtml;
                   /*$optionHtml = '<a href="' .route('admin.equipment-list.detail', ['id' => $data['equipment_no']]). '" class="" target="_blank"><span>Unassigned</span></a>';
                   return $optionHtml;*/
               }
           })
           ->addColumn('equipment_status', function ($data) {
               if($data->equipment_status_id){
                   $status = DB::selectOne('select status_name from l_equipment_status where equipment_status_id =:equipment_status_id', ['equipment_status_id' => $data->equipment_status_id]);
                   return $status->status_name;
               }else{
                   return '';
               }
           })

           ->addColumn('equipment_id', function ($data) {
               $optionHtml = '<a href="' .route('admin.equipment-list.detail', ['id' => $data['equipment_no']]). '" class="" target="_blank"><span>'.$data['equipment_no'].'</span></a>';
               return $optionHtml;
           })

           ->addColumn('action', function ($data) {
               $optionHtml = '';
               if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') || auth()->user()->hasRole('CCMS_ADMIN')){
                   $optionHtml .= '<a href="' . route('admin.equipment-list.index', ['id' => $data['equipment_no']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               }
               $optionHtml .= '<a href="' .route('admin.equipment-list.detail', ['id' => $data['equipment_no']]). '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
               if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') || auth()->user()->hasRole('CCMS_ADMIN')){
                   $optionHtml .= ' <a class="confirm-delete text-danger" href="'.$data['equipment_no'].'"><i class="bx bx-trash cursor-pointer"></i></a>';
               }
               if ($data['invoice'])
               $optionHtml .= ' <a href="' .route('download-equipment-invoice', ['id' => $data['equipment_no']]). '" target="_blank"><i class="bx bx-download cursor-pointer"></i></a>';


               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }

    /**
     * @param array $postData
     */
   public function saveEquipment($id = null, Request $request) {
       if ($id) {
           return $this->equipment_upd($id, $request);
       }
       else {
          return $this->equipment_ins($request);
       }
   }

    /**
     * @param $equipmentNo
     * @return bool
     */
   public function delEquipment($equipmentNo) {
        $equipment = $this->equipmentListRepo->findOne($equipmentNo);
        if ($equipment) {
           return $this->equipment_del($equipmentNo);
        }
        return false;
   }

    /**
     * Get EquipmentList repo
     *
     * @return EquipmentListRepo
     */
   public function getEquipmentListRepo() {
       return $this->equipmentListRepo;
   }


}
