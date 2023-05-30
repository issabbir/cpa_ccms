<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 4/20/20
 * Time: 04:54 AM
 */

namespace App\Http\Controllers\Ccms;
use App\Entities\Ccms\EquipmentStatus;
use App\Entities\Ccms\ServiceTicket;
use App\Entities\Ccms\VendorList;
use App\Entities\Ccms\TicketType;
use App\Entities\Ccms\TicketPriority;
use App\Entities\Ccms\EquipmentList;
use App\Entities\Ccms\RequisitionMasterList;
use App\Entities\Ccms\L_Requsition_Status;
use App\Managers\Ccms\EquipmentAddManager;
use App\Entities\Security\Report;
/*use App\Entities\Training\TrainingCalenderMaster;
use App\Entities\Training\TrainingInfo;
use App\Entities\Training\TrainingScheduleMaster;*/
use App\Enums\ModuleInfo;
use App\Http\Controllers\Controller;
//use App\Managers\TrainingManager;
use App\Repositories\ThirdPartyServiceRepo;
use Illuminate\Http\Request;
use App\Traits\Security\HasPermission;

class ReportGeneratorController extends Controller
{
    use HasPermission;

    /*public function __construct(TrainingManager $trainingManager)
    {
        $this->trainingManager = $trainingManager;
    }*/
    public function __construct(EquipmentAddManager $equipmentAddManager)
     {
         $this->equipmentAddManager = $equipmentAddManager;

     }

    public function index(Request $request)
    {

        $module = ModuleInfo::MODULE_ID;

        $reportObject = new Report();

        if (auth()->user()->hasGrantAll()) {
            $reports = $reportObject->where('module_id', $module)->orderBy('report_name', 'ASC')->get();
        } else {
            $roles = auth()->user()->getRoles();
            $reports = array();
            foreach ($roles as $role) {
                if (count($role->reports)) {
                    $rpts = $role->reports->where('module_id', $module);
                    foreach ($rpts as $report) {
                        $reports[$report->report_id] = $report;
                    }
                }
            }
        }

        return view('ccms.reportgenerator.index', compact('reports'));
    }

    public function reportParams(Request $request, $id)
    {
        $report = Report::find($id);
      //$getEquipmentList =$this->equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentList();
      $getEquipmentList =$this->equipmentAddManager->getEquipmentAddRepo()->findAllEquipmentAddList();
        $getEquipmentStatus = EquipmentStatus::all();
       $requisitionStatus = L_Requsition_Status::all();
       $getEquipmentID =EquipmentList::all();
       $requisitionMasterList=RequisitionMasterList::all();
       $ticketTypeList=TicketType::all();
       $ticketPriorityList=TicketPriority::all();
       $serviceTicketlist=ServiceTicket::all();
       $vendorList=VendorList::all();
       //dd($getEquipmentID);
        /*$lDept = LDepartment::all();
        $trainingCalMst = TrainingCalenderMaster::all();
        $trainingInfo = TrainingInfo::all();
        $traineeList = $this->trainingManager->traineeList();
        $scheduleMst = TrainingScheduleMaster::all();*/

        /*$reportForm = view('ccms.reportgenerator.report-params', compact('report', 'lDept', 'trainingCalMst', 'trainingInfo', 'traineeList','scheduleMst'))->render();*/
        $reportForm = view('ccms.reportgenerator.report-params', compact('report','getEquipmentList','getEquipmentStatus','getEquipmentID','requisitionStatus','requisitionMasterList','ticketTypeList','ticketPriorityList','serviceTicketlist','vendorList'))->render();

        return $reportForm;
    }

}
