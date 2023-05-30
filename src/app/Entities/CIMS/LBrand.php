<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LBrand extends Model
{
    protected $table = 'CIMS.l_brand';
    protected $primaryKey = 'brand_id';
}
