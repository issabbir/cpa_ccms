<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class L_Department extends Model
{
    protected $table= 'PMIS.L_DEPARTMENT';
    protected $primaryKey = 'DEPARTMENT_ID';


    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->department_name;
    }

    public function getValueAttribute() {
        return $this->department_id;
    }
}
