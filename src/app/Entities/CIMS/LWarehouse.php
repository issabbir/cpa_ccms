<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LWarehouse extends Model
{
    protected $table = 'CIMS.l_warehouse';
    protected $primaryKey = 'warehouse_id';
}
