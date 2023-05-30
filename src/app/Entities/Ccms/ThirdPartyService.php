<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyService extends Model
{
    protected $table= 'THIRD_PARTY_SERVICE';
    protected $primaryKey = 'THIRD_PARTY_SERVICE_ID';

    public $timestamps = false;
}
