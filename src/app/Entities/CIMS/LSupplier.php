<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LSupplier extends Model
{
    protected $table = 'CIMS.l_suppliers';
    protected $primaryKey = 'supplier_id';

    public function supplier_type(){
        return $this->belongsTo(LSupplierType::class,'supplier_type_id');
    }
}
