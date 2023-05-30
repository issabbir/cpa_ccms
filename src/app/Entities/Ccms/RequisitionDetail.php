<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class RequisitionDetail extends Model
{

    protected $table='EQUIPMENT_REQUISITION_DTL';
    protected  $primaryKey = 'REQUISITION_DTL_NO';

    public $timestamps = false;
}
