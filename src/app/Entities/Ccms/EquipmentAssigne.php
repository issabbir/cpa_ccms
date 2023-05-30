<?php

namespace App\Entities\Ccms;

use App\Entities\Admin\LDepartment;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class EquipmentAssigne extends Model
{
    protected $table= 'EQUIPMENT_ASSIGN';
    protected $primaryKey = 'EQUIPMENT_ASSIGN_ID';

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function department() {
        return $this->belongsTo(LDepartment::class, 'DEPARTMENT_ID');
    }
}
