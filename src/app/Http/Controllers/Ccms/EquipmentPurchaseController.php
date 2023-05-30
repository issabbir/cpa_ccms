<?php

namespace App\Http\Controllers\Ccms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentPurchaseController extends Controller
{
    public function getEquipmentPurchase()
    {
        return view('ccms.equipment_purchase_approval');
    }
}
