<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class EquipmentReceive extends Model
{
    protected $table='SERVICE_EQUIPMENT_RECEIVE';
    protected  $primaryKey='RECEIPT_NO';

    public $timestamps = false;
}
