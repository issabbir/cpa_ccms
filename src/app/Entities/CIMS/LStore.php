<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use App\Entities\Admin\LDepartment;
use Illuminate\Database\Eloquent\Model;

class LStore extends Model
{
    protected $table = 'CIMS.l_store';
    protected $primaryKey = 'store_id';

    public function storeType(){
        return  $this->belongsTo(LStoreType::class,'store_type_id');
    }
    public function location(){
        return  $this->belongsTo(LLocation::class,'location_id');
    }
    public function department(){
        return  $this->belongsTo(LDepartment::class,'department_id');
    }


}
