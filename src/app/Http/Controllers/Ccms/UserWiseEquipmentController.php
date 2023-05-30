<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserWiseEquipmentController extends Controller
{

    public function getUserEuipment() {
        return view('ccms.user_wise_equipment');
    }


}
