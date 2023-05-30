<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\FAS;

use Illuminate\Database\Eloquent\Model;

class SupplierType extends Model
{
    protected $table = 'cpaacc.l_ap_vendor_type';
    protected $primaryKey = 'vendor_type_id';
    //protected $appends = ['supplier_id'];

//    public function getSupplieIdrAttribute(){
//         return $this->vendor_id;
//    }
}
