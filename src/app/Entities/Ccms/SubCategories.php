<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubCategories extends Model
{
    protected $table= 'L_EQUIPMENT_SUB_CATAGORY';
    protected $primaryKey = 'sub_catagory_no';
}
