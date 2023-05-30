<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class ItemInventoryDetails extends Model
{
    protected $table = 'CIMS.ITEM_INVENTORY_DETAILS';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}

