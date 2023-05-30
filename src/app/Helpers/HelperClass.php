<?php
//app/Helpers/HelperClass.php
namespace App\Helpers;

use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoThana;
use App\Entities\Ams\LPriorityType;
use App\Entities\Ams\OperatorMapping;
use App\Entities\Ccms\Categories;
use App\Entities\Security\Menu;
use App\Entities\Security\Role;
use App\Entities\Security\SecUserRoles;
use App\Enums\Secdbms\Watchman\AppointmentType;
use App\Managers\Authorization\AuthorizationManager;
use App\Managers\Ccms\ThirdPartyServiceManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HelperClass
{

    public $id;
    public $links;

    public static function breadCrumbs($routeName)
    {//dd($routeName);
        if (in_array($routeName, ['category.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Manage Categories', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['sub_category.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Manage Categories', 'action_name' => ''],
                ['submenu_name' => ' Manage Sub Categories', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['engineer_skill.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Service Engineer Skill', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['service_status.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Service Status', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['vendors.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Manage Vendors', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['contact-person.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Manage Vendors', 'action_name' => ''],
                ['submenu_name' => ' Add Contact Person Info', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['ticket_type.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Ticket Type', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['vendor_type.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Vendor Type', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['service-engineer-info.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Service Engineer Info', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.service-engineer-info.detail-view'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Service Engineer Info', 'action_name' => ''],
                ['submenu_name' => ' Service Engineer Info Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['ticket_priority.index'])) {
            return [
                ['submenu_name' => 'Setup', 'action_name' => ''],
                ['submenu_name' => ' Ticket Priority', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.equipment-list.index'])) {
            return [
                ['submenu_name' => 'Equipments', 'action_name' => ''],
                ['submenu_name' => ' Equipment List', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.equipment-list.detail'])) {
            return [
                ['submenu_name' => 'Equipments', 'action_name' => ''],
                ['submenu_name' => ' Equipment List', 'action_name' => ''],
                ['submenu_name' => ' Equipment Detail Information', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.equipment-add.index'])) {
            return [
                ['submenu_name' => 'Equipments', 'action_name' => ''],
                ['submenu_name' => ' Equipment Items', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.equipment-add.detail'])) {
            return [
                ['submenu_name' => 'Equipments', 'action_name' => ''],
                ['submenu_name' => ' Equipment Items', 'action_name' => ''],
                ['submenu_name' => ' Equipment Add Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.equipment-receive.index'])) {
            return [
                ['submenu_name' => 'Equipments', 'action_name' => ''],
                ['submenu_name' => ' Equipment Receive', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.equipment-receive.detail'])) {
            return [
                ['submenu_name' => 'Equipments', 'action_name' => ''],
                ['submenu_name' => ' Equipment Receive', 'action_name' => ''],
                ['submenu_name' => ' Equipment Receive Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['service-engineer-tickets.index'])) {
            return [
                ['submenu_name' => 'Issue Trackers', 'action_name' => ''],
                ['submenu_name' => ' Assigned tickets', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['service-engineer-ticket.ticket-dtl'])) {
            return [
                ['submenu_name' => 'Issue Trackers', 'action_name' => ''],
                ['submenu_name' => ' Assigned Tickets', 'action_name' => ''],
                ['submenu_name' => ' Assigned Ticket Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['service_ticket.index'])) {
            return [
                ['submenu_name' => 'Issue Trackers', 'action_name' => ''],
                ['submenu_name' => ' Available tickets', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['service_ticket.ticket_dtl'])) {
            return [
                ['submenu_name' => 'Issue Trackers', 'action_name' => ''],
                ['submenu_name' => ' Available tickets', 'action_name' => ''],
                ['submenu_name' => ' Service Ticket Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['my_ticket.index'])) {
            return [
                ['submenu_name' => 'Issue Trackers', 'action_name' => ''],
                ['submenu_name' => ' My tickets', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['my_ticket.ticket_dtl'])) {
            return [
                ['submenu_name' => 'Issue Trackers', 'action_name' => ''],
                ['submenu_name' => ' My Tickets', 'action_name' => ''],
                ['submenu_name' => ' My Ticket Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.requisition-master.index'])) {
            return [
                ['submenu_name' => 'Requisitions', 'action_name' => ''],
                ['submenu_name' => ' Available Requisitions', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.requisition-master.detail-view'])) {
            return [
                ['submenu_name' => 'Requisitions', 'action_name' => ''],
                ['submenu_name' => ' Available Requisitions', 'action_name' => ''],
                ['submenu_name' => ' Requisition Details', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.third_party.index'])) {
            return [
                ['submenu_name' => 'Services (3rd party)', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['admin.third_party.detail-view'])) {
            return [
                ['submenu_name' => 'Services (3rd party)', 'action_name' => ''],
                ['submenu_name' => ' Service Detail', 'action_name' => '']
            ];
        } else {
            $breadMenus = [];

            try {
                $authorizationManager = new AuthorizationManager();
                $getRouteMenuId = $authorizationManager->findSubMenuId($routeName);
                if ($getRouteMenuId && !empty($getRouteMenuId)) {
                    $breadMenus[] = $bm = $authorizationManager->findParentMenu($getRouteMenuId);
                    if ($bm && isset($bm['parent_submenu_id']) && !empty($bm['parent_submenu_id'])) {
                        $breadMenus[] = $authorizationManager->findParentMenu($bm['parent_submenu_id']);
                    }
                }
            } catch (\Exception $e) {
                return false;
            }

            return is_array($breadMenus) ? array_reverse($breadMenus) : false;
        }
    }

    public static function findDistrictByDivision($divisionId)
    {
        return LGeoDistrict::where('geo_division_id', $divisionId)->get();
    }

    public static function findDivisionByThana ($districtId)
    {
        return LGeoThana::where('geo_district_id', $districtId)->get();
    }

    public static function isNewspaper($typeId)
    {
        return ( (AppointmentType::NEWSPAPER_ADVERTISEMENT == $typeId) || ($typeId == null) );
    }

    public static function isSupplierAgency($typeId)
    {
        return (AppointmentType::SUPPLIER_AGENCY == $typeId);
    }

    public const REQUIRED = 'required';

    public static function getRequiredForNewsPaper($typeId)
    {
        if(static::isNewspaper($typeId))
            return static::REQUIRED;

        return '';
    }

    public static function getRequiredForSupplierAgency($typeId)
    {
        if(static::isSupplierAgency($typeId))
            return static::REQUIRED;

        return '';
    }

    public static function categoryMenu() {
//$val = $this->CategoryTree();
        $category = new Categories();
        $categories = $category->orderBy('sort_order', 'asc')->get(
            [
               'catagory_no', 'catagory_name', 'parent_id', 'catagory_name_bn', 'catagory_id', 'sort_order','active_yn'
            ]
        )->toArray();


        return self::categoriesToTree($categories);
    }

    public static function categoriesToTree(&$categories) {

        $map = array(
            0 => array('child' => array())
        );

        foreach ($categories as &$category) {
            $category['child'] = array();
            $map[$category['catagory_id']] = &$category;
        }

        foreach ($categories as &$category) {
            $map[$category['parent_id']]['child'][] = &$category;
        }
//dd($map);
        return $map[0]['child'];
    }
    public static function stocks($item_id){
        $sql = "SELECT b.item_id,
                       b.item_name,
                       c.department_name,
                       d.store_name,
                       e.brand_id,
                       e.brand_name,
                       a.store_id,
                       a.variants_string,
                       a.department_id,
                       h.unit_code,
                       a.stock_quantity,
                       w.warehouse_id,
                       w.warehouse_name
                FROM cims.vw_item_stock     a,
                     cims.l_item                 b,
                     cims.departments            c,
                     cims.l_store                d,
                     cims.l_brand                e,
                     cims.l_measurement_of_unit  h,
                     cims.l_warehouse            w
                WHERE     a.item_id = b.item_id
                  AND a.department_id = c.department_id(+)
                  AND a.store_id = d.store_id(+)
                  AND a.brand_id = e.brand_id(+)
                  AND a.unit_id = h.unit_id(+)
                  AND a.warehouse_id = w.warehouse_id(+)
                  AND a.item_id = :p_item_id
                  AND a.department_id = :department_id";

        $data = DB::select($sql, ['p_item_id' => $item_id,'department_id' => 10]);

        return $data;
    }
    public static function stockCheck($item_id,$brand_id,$variants){
       // dd($item_id);
        $sql = "SELECT b.item_id,
                       b.item_name,
                       c.department_name,
                       d.store_name,
                       e.brand_id,
                       e.brand_name,
                       a.store_id,
                       a.variants_string,
                       a.department_id,
                       h.unit_code,
                       a.stock_quantity
                FROM cims.vw_item_stock     a,
                     cims.l_item                 b,
                     cims.departments            c,
                     cims.l_store                d,
                     cims.l_brand                e,
                     cims.l_measurement_of_unit  h
                WHERE     a.item_id = b.item_id
                  AND a.department_id = c.department_id(+)
                  AND a.store_id = d.store_id(+)
                  AND a.brand_id = e.brand_id(+)
                  AND a.unit_id = h.unit_id(+)
                  AND a.item_id = :p_item_id AND a.department_id = :department_id";

                  if($brand_id){
                     $sql .= " AND a.brand_id = $brand_id";
                  }
                 if($variants){
                    $sql .= " AND a.variants_string = '$variants'";
                  }

        $data = DB::select($sql, ['p_item_id' => $item_id,'department_id' => 10]);

        return $data;
    }

    public static function sendNotification($role,$message,$url){
        $adminRole = Role::where('role_key',$role)->first();
        $users = SecUserRoles::where('role_id',$adminRole->role_id)->get();
        foreach ($users as $user){
            self::sendToNotification($user->user_id,$message,41,$url);
        }
    }
    public static function sendToNotification($notification_to,$note,$module_id,$url=null,$priority=null){
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


    public static function readToNotification($notification_to,$note,$module_id,$url=null,$priority=null){
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
}
