<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentVendorRegisterController extends Controller
{

    public function getVendorRigister() {
        return view('ccms.equipment_vendor_register');
    }


}
