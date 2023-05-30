<?php

namespace App\Entities\Ccms;

use App\Entities\FAS\Supplier;
use Illuminate\Database\Eloquent\Model;

class EquipmentAdd extends Model
{
    protected $table= 'EQUIPMENT_ADD';
    protected $primaryKey = 'EQUIPMENT_ADD_NO';

    public function vendor() {
        return $this->belongsTo(Supplier::class, 'vendor_no','vendor_id');
    }
}
