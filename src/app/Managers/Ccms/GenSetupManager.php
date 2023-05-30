<?php


namespace App\Managers\Ccms;


use App\Managers\ProcedureManager;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use App\Repositories\ContactPersonRepo;

use App\Repositories\VendorRepo;
use App\Repositories\CatagoryRepo;
use App\Repositories\SubCatagoryRepo;
use App\Repositories\EngineerSkillRepo;
use App\Repositories\ServiceStatusRepo;
use App\Repositories\ServiceTicketActionListRepo;
use App\Repositories\TicketPriorityRepo;
use App\Repositories\TicketTypeRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GenSetupManager extends ProcedureManager
{
  /** @var VendorRepo  */
  protected $vendorRepo;
  /** @var CatagoryRepo  */
  protected $catagoryRepo;
  /** @var CatagoryRepo  */
  protected $subCatagoryRepo;
  /** @var ContactPersonRepo  */
  protected $contactPersonRepo;
  /** @var serviceStatusRepo  */
  protected $serviceStatusRepo;
  /** @var serviceTicketActionListRepo  */
  protected $serviceTicketActionListRepo;
  /** @var ticketPriorityRepo  */
  protected $ticketPriorityRepo;
  /** @var ticketTypeRepo  */
  protected $ticketTypeRepo;






    /**
     * GenSetupManager constructor.
     *
     * @param VendorRepo $vendorRepo
     * @param CatagoryRepo $catagoryRepo
      * @param ContactPersonRepo $contactPersonRepo
     */

   public function __construct(VendorRepo $vendorRepo, CatagoryRepo $catagoryRepo,ContactPersonRepo $contactPersonRepo, EngineerSkillRepo $engineerSkillRepo, ServiceStatusRepo $serviceStatusRepo, ServiceTicketActionListRepo $serviceTicketActionListRepo, TicketPriorityRepo $ticketPriorityRepo, TicketTypeRepo $ticketTypeRepo, SubCatagoryRepo $subCatagoryRepo)

   {
       $this->vendorRepo = $vendorRepo;
       $this->catagoryRepo = $catagoryRepo;
       $this->contactPersonRepo = $contactPersonRepo;
       $this->engineerSkillRepo = $engineerSkillRepo;
       $this->serviceStatusRepo = $serviceStatusRepo;
       $this->serviceTicketActionListRepo = $serviceTicketActionListRepo;
       $this->ticketPriorityRepo = $ticketPriorityRepo;
       $this->ticketTypeRepo = $ticketTypeRepo;
       $this->subCatagoryRepo = $subCatagoryRepo;




   }

    /**
     * Get vendor table based on datatable
     * SubCatagoryRepo $subCatagoryRepo
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getVendorTables(Request $request) {
       $data = $this->vendorRepo->findAll();
       // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
               // dd($data);

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
              $optionHtml = '<a href="' . route('vendors.index', ['id' => $data['vendor_no']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= ' <a class="confirm-delete text-danger" href="' . '' . '"><i class="bx bx-trash cursor-pointer"></i></a>';
               $optionHtml .= ' <a class="btn btn-sm btn-primary" title="Add Contact Person" href="' .route('contact-person.index', ['vendor_no' => $data['vendor_no']]).'"><i class="bx bx-plus"></i>Add Contacts</a>';

               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * @param array $postData
     */
   public function saveVendor($id = null, Request $request) {
       if ($id) {
           return $this->gen_setup_vendor_upd($id, $request);
       }
       else {
          return $this->gen_setup_vendor_ins($request);
       }
   }

    /***
     * @param Request $request
     * @return array
     */
    public function gen_setup_vendor_ins(Request $request)
    {
        return $this->execute('GEN_SETUP.VENDOR_INS', $request)
               ->getParams();
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function gen_setup_vendor_upd($id, Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_vendor_no" => $id,
                "p_vendor_id" => $request->get("vendor_id"),
                "p_vendor_name" => $request->get("vendor_name"),
                "p_vendor_name_bn" => $request->get("vendor_name_bn"),
                "p_vendor_type_no" => $request->get("vendor_type_no"),
                "p_vendor_address" => $request->get("vendor_address"),
                "p_email" => $request->get("email"),
                "p_fax" => $request->get("fax"),
                "p_mobile" => $request->get("mobile"),
                "p_update_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("GEN_SETUP.VENDOR_UPD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function gen_setup_vendor_del(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_vendor_id" => $request->get("vendor_id"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("GEN_SETUP.VENDOR_DEL", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }




    /**
     * @param $vendorNo
     * @return bool
     */
   public function delVendor($vendorNo) {
        $vendor = $this->vendorRepo->findOne($vendorNo);
        if ($vendor) {
           return $this->gen_setup_vendor_del($vendorNo);
        }
        return false;
   }

    /**
     * Get Vendor repo
     *
     * @return VendorRepo
     */
   public function getVendorRepo() {
       return $this->vendorRepo;
   }
    /**
     * @param array $postData
     */
    public function saveContactPerson($id = null, Request $request) {
        if ($id) {
            return $this->gen_setup_contactPerson_upd($id, $request);
        }
        else {
            return $this->gen_setup_contactPerson_ins($request);
        }
    }

    /***
     * @param Request $request
     * @return array
     */
    public function gen_setup_contactPerson_ins(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_vendor_id" => $request->get("vendor_id"),
                "p_contact_person_name" => $request->get("contact_person_name"),
                "p_contact_person_name_bn" => $request->get("contact_person_name_bn"),
                "p_email" => $request->get("email"),
                "p_mobile_no" => $request->get("mobile_no"),
                "p_remarks" => $request->get("remarks"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("GEN_SETUP.CONTACT_PERSON_INS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function gen_setup_contactPerson_upd($id, Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_contact_person_id" =>$id,
                "p_vendor_id" => $request->get("vendor_id"),
                "p_contact_person_name" => $request->get("contact_person_name"),
                "p_contact_person_name_bn" => $request->get("contact_person_name_bn"),
                "p_email" => $request->get("email"),
                "p_mobile_no" => $request->get("mobile_no"),
                "p_update_by" =>Auth::id(),
                "p_remarks" => $request->get("remarks"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("GEN_SETUP.CONTACT_PERSON_UPD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function gen_setup_contactPerson_del(Request $request)
    {

        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_contact_person_id" => $request->get("contact_person_id"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("GEN_SETUP.CONTACT_PERSON_DEL", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }




    /**
     * @param $contactPersonId
     * @return bool
     */
    public function delContactPerson($contactPersonId) {
        $contactPerson = $this->contactPersonRepo->findOne($contactPersonId);
        if ($contactPerson) {
            return $contactPerson->delete();
        }

        return false;
    }
    /**
     * Get contact person repo
     *
     * @return contactPersonRepo
     */
    public  function getContactPersonRepo(){
        return $this->contactPersonRepo;
    }
    /**
     * Get contact Person table based on datatable
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getContactPersonTables($vendor_no, Request $request) {
        $vendor = $this->getVendorRepo()->findOne($vendor_no);
        $data = $this->contactPersonRepo->findVendorContactPersons($vendor->vendor_id);
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('insert_date', function ($data) {

                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
            ->addColumn('action', function ($data) use($vendor_no){
                $optionHtml = '<a href="' . route('contact-person.index', ['vendor_no' =>$vendor_no, 'id' => $data['contact_person_id']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
                $optionHtml .= ' <a class="confirm-delete text-danger" href="' . '' . '"><i class="bx bx-trash cursor-pointer"></i></a>';

                return $optionHtml;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getCategoryTables(Request $request) {
       $data = $this->catagoryRepo->findAll();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('category.index', ['id' => $data['catagory_no']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Category"></i></a>';
                $optionHtml .= ' <span>|</span> <a class="sub-category-modal" data-id="" href="' .route('sub_category.index', ['catagory_no' => $data['catagory_no']]).'"><i class="bx bx-plus" title="Add Sub Category"></i></a>';
                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }

    /**
     * @param array $postData
     */
   public function saveCatagory($id = null, Request $request) {
       if ($id) {
           return $this->gen_setup_catagory_upd($id, $request);
       }
       else {
          return $this->gen_setup_catagory_ins($request);
       }
   }

   /***
    * @param Request $request
    * @return array
    */
   public function gen_setup_catagory_ins(Request $request)
   {

      return $this->execute('GEN_SETUP.CAT_INS', $request)
             ->getParams();
   }
    /***
    * @param Request $request
    * @return array
    */
   public function gen_setup_catagory_upd($id, Request $request)
   {
       return $this->execute('GEN_SETUP.CAT_UPD', $request)
               ->getParams();
   }

    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getCategoryRepo() {
       return $this->catagoryRepo;
   }

   /**
    * Get Sub Catagory table based on datatable
    *
    * @param Request $request
    * @return mixed
    * @throws \Exception
    */
   public function getSubCatagoryTables($catagory_no, Request $request) {
       $catagory = $this->getCategoryRepo()->findOne($catagory_no);
       $data = $this->subCatagoryRepo->findSubCatagories($catagory->catagory_no);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {

               return  date('d-m-Y h:i A',strtotime($data['created_at']));
           })
           ->addColumn('action', function ($data) use($catagory_no){
               $optionHtml = '<a href="' . route('sub_category.index', ['catagory_no' =>$catagory_no, 'id' => $data['sub_catagory_no']]) . '" class=""><i class="bx bx-edit cursor-pointer"></i></a>';
               $optionHtml .= ' <a class="confirm-delete text-danger" href="' . '' . '"><i class="bx bx-trash cursor-pointer"></i></a>';

               return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }



    /**
     * @param array $postData
     */
   public function saveSubCatagory($id = null, Request $request) {
       if ($id) {
           return $this->gen_setup_sub_catagory_upd($id, $request);
       }
       else {
          return $this->gen_setup_sub_catagory_ins($request);
       }
   }

   /***
    * @param Request $request
    * @return array
    */
   public function gen_setup_sub_catagory_ins(Request $request)
   {

      return $this->execute('GEN_SETUP.SUB_CAT_INS', $request)
             ->getParams();
   }
    /***
    * @param Request $request
    * @return array
    */
   public function gen_setup_sub_catagory_upd($id, Request $request)
   {
       return $this->execute('GEN_SETUP.SUB_CAT_UPD', $request)
               ->getParams();
   }



    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getSubCatagoryRepo() {
       return $this->subCatagoryRepo;
   }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getEngineerSkillTables(Request $request) {
       $data = $this->engineerSkillRepo->findAll();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('engineer_skill.index', ['id' => $data['service_skill_id']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Engineer Skill"></i></a>';
                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getEngineerSkillRepo() {
       return $this->engineerSkillRepo;
   }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getServiceStatusTables(Request $request) {
       $data = $this->serviceStatusRepo->findAll();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
//                $optionHtml = '<a href="' . route('service_status.index', ['id' => $data['status_no']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Category"></i></a>';
//                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getServiceStatusRepo() {
       return $this->serviceStatusRepo;
   }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getServiceTicketActionListTables(Request $request) {
       $data = $this->serviceTicketActionListRepo->findAll();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('service_ticket_action.index', ['id' => $data['action_no']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Category"></i></a>';
                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getServiceTicketActionListRepo() {
       return $this->serviceTicketActionListRepo;
   }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getTicketPriorityTables(Request $request) {
       $data = $this->ticketPriorityRepo->findAll();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('ticket_priority.index', ['id' => $data['ticket_priority_no']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Priority"></i></a>';
                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getTicketPriorityRepo() {
       return $this->ticketPriorityRepo;
   }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getTicketTypeTables(Request $request) {
       $data = $this->ticketTypeRepo->findAll();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('ticket_type.index', ['id' => $data['ticket_type_no']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Priority"></i></a>';
                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getTicketTypeRepo() {
       return $this->ticketTypeRepo;
   }

    /**
     * Get category table based on datatable
     * , ['catagory_no' => $data['catagoryNo']]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
   public function getVendorTypeTables(Request $request) {
       $data = $this->vendorRepo->findAllVendorType();
      // dd($data);
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('insert_date', function ($data) {
                // dd($data);
                return  date('d-m-Y h:i A',strtotime($data['created_at']));
            })
           ->addColumn('action', function ($data) {
                $optionHtml = '<a href="' . route('vendor_type.index', ['id' => $data['vendor_type_no']]) . '" class=""><i class="bx bx-edit cursor-pointer" title="Edit Priority"></i></a>';
                return $optionHtml;
           })
           ->escapeColumns([])
           ->make(true);
   }


    /**
     * Get Catagory repo
     *
     * @return CatagoryRepo
     */
   public function getVendorTypeRepo() {
       return $this->vendorRepo;
   }





}
