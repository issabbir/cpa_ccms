<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class ItemInventory extends Model
{
    protected $table = 'CIMS.item_inventory';
    protected $primaryKey = 'item_inventory_id';

    public function item()
    {
        return $this->belongsTo(LItem::class, 'item_id');
    }
}

