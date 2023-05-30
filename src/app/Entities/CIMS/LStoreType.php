<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LStoreType extends Model
{
    protected $table = 'CIMS.l_store_type';
    protected $primaryKey = 'store_type_id';

}
