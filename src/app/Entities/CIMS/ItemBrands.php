<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class ItemBrands extends Model
{
    protected $table = 'CIMS.item_brands';
    protected $primaryKey = 'item_id';

    public function brand()
    {
        return $this->belongsTo(LBrand::class, 'brand_id','brand_id');
    }

}
