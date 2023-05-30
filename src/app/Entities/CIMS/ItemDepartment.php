<?php

namespace App\Entities\CIMS;

use App\Entities\Admin\LDepartment;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ItemDepartment extends Model
{
    protected $table = 'CIMS.item_departments';
    protected $primaryKey = 'item_id';

    protected $with = ['department'];

    public function department()
    {
        return $this->belongsTo(LDepartment::class, 'department_id','department_id');
    }
}
