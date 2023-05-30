<?php
namespace App\Helpers;

use App\Entities\Admin\LGeoDistrict;
use App\Entities\Ams\LPriorityType;
use App\Entities\Ams\OperatorMapping;
use App\Entities\Security\Menu;
use App\Enums\ModuleInfo;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CcmsClass
{

    public $id;
    public $links;

    /**
     * @return mixed
     */
    public static function menuSetup()
    {
        if (Auth::user()->hasGrantAll()) {
            $moduleId = ModuleInfo::MODULE_ID;
            $menus = Menu::where('module_id', $moduleId)->orderBy('menu_order_no')->get();

            return $menus;
        } else {
            $allMenus = Auth::user()->getRoleMenus();
            $menus = [];

            if($allMenus) {
                foreach($allMenus as $menu) {
                    if($menu->module_id == ModuleInfo::MODULE_ID) {
                        $menus[] = $menu;
                    }
                }
            }

            return $menus;
        };
    }

    public static function getActiveRouteNameWrapping($routeName)
    {//dd($routeName);
        if (in_array($routeName, ['category.index'])) {
            return 'ccms.setup.category.index';
        } else if (in_array($routeName, ['sub_category.index'])) {
            return 'ccms.setup.category.index';
        } else if (in_array($routeName, ['engineer_skill.index'])) {
            return 'ccms.setup.engineer_skill.index';
        } else if (in_array($routeName, ['service_status.index'])) {
            return 'ccms.setup.service_status.index';
        } else if (in_array($routeName, ['vendors.index'])) {
            return 'ccms.setup.vendor.index';
        } else if (in_array($routeName, ['contact-person.index'])) {
            return 'ccms.setup.vendor.index';
        } else if (in_array($routeName, ['ticket_type.index'])) {
            return 'ccms.setup.ticket_type.index';
        } else if (in_array($routeName, ['vendor_type.index'])) {
            return 'ccms.setup.vendor_type.index';
        } else if (in_array($routeName, ['service-engineer-info.index'])) {
            return 'ccms.service-engineer-info';
        } else if (in_array($routeName, ['admin.service-engineer-info.detail-view'])) {
            return 'ccms.service-engineer-info';
        } else if (in_array($routeName, ['ticket_priority.index'])) {
            return 'ccms.setup.ticket_priority.index';
        } else if (in_array($routeName, ['admin.equipment-list.index'])) {
            return 'ccms.admin.equipment';
        } else if (in_array($routeName, ['admin.equipment-list.detail'])) {
            return 'ccms.admin.equipment';
        } else if (in_array($routeName, ['admin.equipment-add.index'])) {
            return 'ccms.admin.equipment-add';
        } else if (in_array($routeName, ['admin.equipment-add.detail'])) {
            return 'ccms.admin.equipment-add';
        } else if (in_array($routeName, ['admin.equipment-receive.index'])) {
            return 'ccms.admin.equipment-receive';
        } else if (in_array($routeName, ['admin.equipment-receive.detail'])) {
            return 'ccms.admin.equipment-receive';
        } else if (in_array($routeName, ['service-engineer-tickets.index'])) {
            return 'ccms.service-engineer.ticket.list';
        } else if (in_array($routeName, ['service-engineer-ticket.ticket-dtl'])) {
            return 'ccms.service-engineer.ticket.list';
        } else if (in_array($routeName, ['service_ticket.index'])) {
            return 'ccms.admin.ticket.list';
        } else if (in_array($routeName, ['service_ticket.ticket_dtl'])) {
            return 'ccms.admin.ticket.list';
        } else if (in_array($routeName, ['my_ticket.index'])) {
            return 'ccms.setup.service_ticket_action.index';
        } else if (in_array($routeName, ['my_ticket.ticket_dtl'])) {
            return 'ccms.setup.service_ticket_action.index';
        } else if (in_array($routeName, ['admin.requisition-master.index'])) {
            return 'ccms.admin.requisition';
        } else if (in_array($routeName, ['admin.requisition-details.index'])) {
            return 'ccms.admin.requisition';
        } else if (in_array($routeName, ['admin.requisition-master.detail-view'])) {
            return 'ccms.admin.requisition';
        } else if (in_array($routeName, ['admin.third_party.index'])) {
            return 'ccms.admin.services';
        } else if (in_array($routeName, ['admin.third_party.detail-view'])) {
            return 'ccms.admin.services';
        } else {
            return [
                [
                    'submenu_name' => $routeName,
                ]
            ];
        }
    }

    public static function activeMenus($routeName)
    {
        //$menus = [];
        try {
            $authorizationManager = new AuthorizationManager();
            $menus[] = $getRouteMenuId = $authorizationManager->findSubMenuId(self::getActiveRouteNameWrapping($routeName));

            if ($getRouteMenuId && !empty($getRouteMenuId)) {
                $bm = $authorizationManager->findParentMenu($getRouteMenuId);
                $menus[] = $bm['parent_submenu_id'];
                if ($bm && isset($bm['parent_submenu_id']) && !empty($bm['parent_submenu_id'])) {
                    $m = $authorizationManager->findParentMenu($bm['parent_submenu_id']);
                    if (!empty($m['submenu_id'])) {
                        $menus[] = $m['submenu_id'];
                    }
                }
            }
        } catch (\Exception $e) {
            $menus = [];
        }
        return is_array($menus) ? $menus : false;
    }

    public static function hasChildMenu($routeName)
    {
        $authorizationManager = new AuthorizationManager();
        $getRouteMenuId = $authorizationManager->findSubMenuId($routeName);
        return $authorizationManager->hasChildMenu($getRouteMenuId);
    }
}
