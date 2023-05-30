<?php

namespace App\Entities\CIMS;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'CIMS.departments';
    protected $primaryKey = 'department_id';
}
