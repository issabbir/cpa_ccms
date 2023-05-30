<?php
namespace App\Contracts\Ccms;


interface EquipmentListContract
{
    public function ecLiCud($action_type=null, $request = [], $id=0);
    public function ecLiDatatable();
}
