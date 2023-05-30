<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;


class VendorList extends Model
{
    protected $table= 'VENDOR_LIST';
    protected $primaryKey = 'VENDOR_NO';
    //protected $with = ['contact_persons'];

//    public function contact_persons() {
//        return $this->belongsTo(ContactPersonList::class, 'vendor_id');
//    }
}



