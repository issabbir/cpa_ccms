<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentRegisterController extends Controller
{

    public function getRigister() {
        return view('ccms.equipment_register');
    }

}
