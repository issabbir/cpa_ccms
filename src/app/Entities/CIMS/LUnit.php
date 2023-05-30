<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Hossian
 * Date: 14/01/21
 * Time: 10:00 AM
 */

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class LUnit extends Model
{
    protected $table = 'cims.l_measurement_of_unit';
    protected $primaryKey = 'unit_id';
}
