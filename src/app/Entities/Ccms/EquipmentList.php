<?php

namespace App\Entities\Ccms;

use App\Entities\FAS\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EquipmentList extends Model
{
    protected $table='EQUIPMENT_LIST';
    protected  $primaryKey='EQUIPMENT_NO';

//    public function vendor() {
//        return $this->belongsTo(VendorList::class, 'vendor_no');
//    }
    public function vendor() {
        return $this->belongsTo(Supplier::class, 'vendor_no','vendor_id');
    }

    public function status() {
        return $this->belongsTo(EquipmentStatus::class, 'EQUIPMENT_STATUS_ID');
    }

    public function equipassign() {
        return $this->belongsTo(EquipmentAssigne::class, 'EQUIPMENT_ASSIGN_ID');
    }

}
