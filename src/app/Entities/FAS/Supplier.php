<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\FAS;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'cpaacc.fas_ap_vendors';
    protected $primaryKey = 'vendor_id';
    //protected $appends = ['supplier_id'];

//    public function getSupplieIdrAttribute(){
//         return $this->vendor_id;
//    }


    public function suplier_type()
    {
        return $this->belongsTo(SupplierType::class,'vendor_type_id');
    }
}
