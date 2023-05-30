<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class RequisitionMasterList extends Model
{

    protected $table='EQUIPMENT_REQUISITION_MST';
    protected  $primaryKey='REQUISITION_MST_NO';
    public $timestamps = false;
   // protected $hidden = ['equipment_description'];

    public function requisition_dtl() {
        return $this->belongsTo(EquipmentRequisitionList::class, 'requisition_mst_no');
    }

    public function equipment() {
        return $this->belongsTo(EquipmentList::class, 'equipment_no');
    }
}
