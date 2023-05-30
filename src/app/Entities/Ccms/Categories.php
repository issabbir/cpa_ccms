<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categories extends Model
{
    protected $table= 'L_EQUIPMENT_CATAGORY';
    protected $primaryKey = 'CATAGORY_NO';


}
