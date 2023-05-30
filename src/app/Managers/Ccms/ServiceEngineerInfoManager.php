<?php


namespace App\Managers\Ccms;


use App\Repositories\ServiceEngineerInfoRepo;
use App\Repositories\EquipmentListRepo;
use App\Repositories\VendorRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceEngineerInfoManager
{
  /** @var ServiceEngineerInfoRepo  */

  protected $serviceEngineerInfoRepo;

    /**
     * EquipmentListManager constructor.
     *
     * @param ServiceEngineerInfoRepo $serviceEngineerInfoRepo
     */

   public function __construct(ServiceEngineerInfoRepo $serviceEngineerInfoRepo)
   {
       $this->serviceEngineerInfoRepo = $serviceEngineerInfoRepo;
   }

    /**
     * Get vendor table based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getServiceEngineerInfoRepoTables(Request $request) {
       $data = $this->serviceEngineerInfoRepo->findAll();
       return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('contract_start_date', function ($data) {
               return Carbon::parse($data->contract_start_date)->format('d-m-Y');
           })
           ->addColumn('contract_end_date', function ($data) {
               return Carbon::parse($data->contract_end_date)->format('d-m-Y');
           })
           ->addColumn('active_yn', function ($data) {
               if($data->active_yn=='Y'){
                   return 'Yes';
               }else{
                   return 'No';
               }
           })
           ->addColumn('action', function ($data) {
               $optionHtml = '<a href="' . route('service-engineer-info.index', ['id' => $data['service_engineer_info_id']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= '<a href="' .route('admin.service-engineer-info.detail-view', ['id' => $data['service_engineer_info_id']]). '" class=""><i class="bx bx-show cursor-pointer"></i></a>';
               $optionHtml .= ' <a class="confirm-delete text-danger" href="' . '' . '"><i class="bx bx-trash cursor-pointer"></i></a>';


               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * @param $serviceEngineerInfoId
     * @return bool
     */
   public function delServiceEngineerInfo($serviceEngineerInfoId) {
        $serviceEngineerInfo = $this->serviceEngineerInfoRepo->findOne($serviceEngineerInfoId);
        if ($serviceEngineerInfo) {
           return $this->serviceEngineerInfo_del($serviceEngineerInfoId);
        }
        return false;
   }

    /**
     * Get EquipmentList repo
     *
     * @return ServiceEngineerInfoRepo
     */
   public function getServiceEngineerInfoRepo() {
       return $this->serviceEngineerInfoRepo;
   }


}
