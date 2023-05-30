<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class EquipmentRequisitionList extends Model
{

    protected $table='EQUIPMENT_REQUISITION_DTL';
    protected  $primaryKey='REQUISITION_DTL_NO';
   // protected $hidden = ['equipment_description'];
}
