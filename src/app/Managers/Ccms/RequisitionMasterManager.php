<?php


namespace App\Managers\Ccms;


use App\Managers\ProcedureManager;
use App\Repositories\ContactPersonRepo;

use App\Repositories\RequisitionMasterRepo;
use App\Repositories\RequisitionDetailsRepo;
use App\Repositories\VendorRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RequisitionMasterManager extends ProcedureManager
{
  /** @var RequisitionMasterRepo  */
    protected $requisitionMasterRepo;
    protected $requisitionRepo;


    /**
     * RequisitionDetailsManager constructor.
     *
     * @param RequisitionMasterRepo $requisitionMasterRepo
     */
   public function __construct(RequisitionMasterRepo $requisitionMasterRepo,RequisitionDetailsRepo $requisitionRepo)
   {
       $this->requisitionMasterRepo = $requisitionMasterRepo;
       $this->requisitionRepo = $requisitionRepo;
   }

    /**
     * Get vendor table based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getRequisitionMasterTables(Request $request) {
       $data = $this->requisitionMasterRepo->findAll();
       //dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
               // dd($data);

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
               $optionHtml = '<a href="' . route('requisition-master.index', ['id' => $data['requisition_mst_no']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= ' <a title="Add Requisition Details" href="' .route('requisition-details.index', ['requisition_mst_no' => $data['requisition_mst_no']]).'"><i class="bx bx-plus"></i></a>';

               $optionHtml .= ' <a class="confirm-delete text-danger" ><i class="bx bx-trash cursor-pointer"></i></a>';
               $optionHtml .= ' <a class="confirm-approved text-success"  href="' . route('requisition-master-data-approved', ['id' => $data['requisition_mst_no']]) . '"><i class="bx bx-check-circle cursor-pointer"></i></a>';

               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }



    /**
     * Get vendor table based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getRequisitionDetailsTables($requisition_mst_no, Request $request) {
        $requisition= $this->getRequisitionMasterRepo()->findOne($requisition_mst_no);
        $data = $this->getRequisitionRepo()->findRequisitionDetails($requisition->requisition_mst_no);

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('insert_date', function ($data) {
                //dd($data);

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
            ->addColumn('action', function ($data)  use ($requisition_mst_no){
                $optionHtml = '<a href="' . route('requisition-details.index', ['requisition_mst_no'=>$requisition_mst_no,'id' => $data['requisition_dtl_no']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                $optionHtml .= ' <a class="confirm-delete text-danger" href="' . '' . '"><i class="bx bx-trash cursor-pointer"></i></a>';


                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param array $postData
     */
    public function saveRequisition( Request $request,$id = null) {
        return $this->execute('REQUISITION.requisition_dtl_crud', $request)->getParams();
    }



    /**
     * Get EquipmentList repo
     *
     * @return EquipmentListRepo
     */
    public function getRequisitionRepo() {
        return $this->requisitionRepo;
    }

    public function getRequisitionMasterRepo() {
        return $this->requisitionMasterRepo;
    }

}
